import { computed, reactive, ref, watch } from "vue";
import { useForm } from '@inertiajs/inertia-vue3'

export default function useTableAction(keyword, searchedTableContents, paginations, tableContents, sortStatus, resetSortStatus) {

    const NEXT = '次 &raquo'
    const NO_VALUE = 0

    //テーブル内検索時にチェックボックス選択結果を検索結果と一致させる
    watch(searchedTableContents, (newval, oldval) => {
        const searchedTableContentIds = newval.map(searchedTableContent => searchedTableContent.id)
        const deleteIds = formDelete.checked.map(deleteId => deleteId)
        const allValues = [...searchedTableContentIds, ...deleteIds]
        const duplicatedValues = allValues.filter(allValue => searchedTableContentIds.includes(allValue) && deleteIds.includes(allValue))

        formDelete.checked = [...new Set(duplicatedValues)];

    })

    //全選択か否かを判定
    const allChecked = computed({
        get: () => {
            return formDelete.checked.length === searchedTableContents.value.length && searchedTableContents.value.length !== 0
        },
        set: (val) => {
            if (val) {
                formDelete.checked = searchedTableContents.value.map((searchedTableContent) => searchedTableContent.id);
            } else {
                formDelete.checked = [];
            }
        }
    });

    //選択削除後の画面遷移先の設定
    const getAfterDeletePageParam = () => {
        paginations.value.forEach((index) => {
            if (index.active) {
                formDelete.page = index.label
            }
            //最終ページを全削除した場合、最後の前のページに遷移
            if (index.url === null && index.label === NEXT && formDelete.checked.length === tableContents.value.length) {
                formDelete.page -= 1
            }
        })
    }

    // データ取得時の作成日順にソート
    const sortDefault = () => {
        searchedTableContents.value.sort((a, b) => sortDown((a.created_at, b.created_at)))
    }

    //昇順にソート
    const sortUp = (titleA, titleB) => {
        if (titleA > titleB) {
            return 1
        } else if (titleA < titleB) {
            return -1
        } else {
            return 0
        }
    }

    //降順にソート
    const sortDown = (titleA, titleB) => {
        if (titleA < titleB) {
            return 1
        } else if (titleA > titleB) {
            return -1
        } else {
            return 0
        }
    }

    //名前昇順にソート
    const sortNameUp = () => {
        if (sortStatus.nameUp) {
            sortDefault()
            sortStatus.nameUp = false
            return
        }

        searchedTableContents.value.sort((a, b) => sortUp(a.name, b.name))
        resetSortStatus()
        sortStatus.nameUp = true
    }

    //名前降順にソート
    const sortNameDown = () => {
        if (sortStatus.nameDown) {
            sortDefault()
            sortStatus.nameDown = false
            return
        }

        searchedTableContents.value.sort((a, b) => sortDown(a.name, b.name))

        resetSortStatus()
        sortStatus.nameDown = true
    }

    //登録日昇順にソート
    const sortCreatedAtUp = () => {
        if (sortStatus.createdAtUp) {
            sortDefault()
            sortStatus.createdAtUp = false
            return
        }

        searchedTableContents.value.sort((a, b) => sortUp(a.created_at, b.created_at))
        resetSortStatus()
        sortStatus.createdAtUp = true
    }

    //登録日降順にソート
    const sortCreatedAtDown = () => {
        if (sortStatus.createdAtDown) {
            sortDefault()
            sortStatus.createdAtDown = false
            return
        }

        searchedTableContents.value.sort((a, b) => sortDown(a.created_at, b.created_at))
        resetSortStatus()
        sortStatus.createdAtDown = true
    }

    //更新日昇順にソート
    const sortUpdatedAtUp = () => {
        if (sortStatus.updatedAtUp) {
            sortDefault()
            sortStatus.updatedAtUp = false
            return
        }

        searchedTableContents.value.sort((a, b) => sortUp(a.updated_at, b.updated_at))
        resetSortStatus()
        sortStatus.updatedAtUp = true
    }

    //更新日降順にソート
    const sortUpdatedAtDown = () => {
        if (sortStatus.updatedAtDown) {
            sortDefault()
            sortStatus.updatedAtDown = false
            return
        }

        searchedTableContents.value.sort((a, b) => sortDown(a.updated_at, b.updated_at))
        resetSortStatus()
        sortStatus.updatedAtDown = true
    }



    //キーワード検索
    const formKeyword = useForm({
        keyword: '',
    })

    const submitKeyword = (url) => {
        formKeyword.get(url, {
            onSuccess: () => {
                formKeyword.reset()
            }
        })
    }

    //選択削除
    const formDelete = useForm({
        checked: [],
        page: null,
        keyword: keyword
    })

    //選択削除のデータ送信
    const submitDelete = (url, selectMessage, deleteMessage) => {
        if (formDelete.checked.length === NO_VALUE) {
            return confirm(selectMessage)
        }
        getAfterDeletePageParam()
        formDelete.post(url, {
            onBefore: () => confirm(deleteMessage)
        })
    }

    return {
        allChecked,
        submitDelete,
        formDelete,
        formKeyword,
        submitKeyword,
        sortNameUp,
        sortNameDown,
        sortCreatedAtUp,
        sortCreatedAtDown,
        sortUpdatedAtUp,
        sortUpdatedAtDown,
    }
}
