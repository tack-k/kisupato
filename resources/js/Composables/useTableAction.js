import {computed, watch} from "vue";

export default function useTableAction(formDelete, searchModels, paginations, models) {

    const NEXT = '次 &raquo'

    //テーブル内検索時にチェックボックス選択結果を検索結果と一致させる
    const matchResults = watch(searchModels, (newval, oldval) => {
        const adminIds = newval.map(admin => admin.id)
        const deleteIds = formDelete.checked.map(deleteId => deleteId)
        const allValues = [...adminIds, ...deleteIds]
        const duplicatedValues = allValues.filter(allValue => adminIds.includes(allValue) && deleteIds.includes(allValue))

        formDelete.checked = [...new Set(duplicatedValues)];

    })

    //全選択か否かを判定
    const allChecked = computed({
        get: () => {
            return formDelete.checked.length === searchModels.value.length && searchModels.value.length !== 0
        },
        set: (val) => {
            if (val) {
                formDelete.checked = searchModels.value.map((model) => model.id);
            } else {
                formDelete.checked = [];
            }
        }
    });

    //選択削除後の画面遷移先の設定
    const getAfterDeletePageParam = () => {
        paginations.forEach((index) => {
            if(index.active) {
                formDelete.page = index.label
            }
            //最終ページを全削除した場合、最後の前のページに遷移
            if(index.url === null && index.label === NEXT && formDelete.checked.length === models.length) {
                formDelete.page -= 1
            }
        })
    }

    // データ取得時の作成日順にソート
    const sortDefault = () => {
        searchModels.value.sort((a, b) => {
            if(a.created_at < b.created_at) {
                return 1
            } else if (a.created_at > b.created_at){
                return -1
            } else {
                return 0
            }
        })
    }

return {
    matchResults,
    allChecked,
    getAfterDeletePageParam,
    sortDefault,
}
}
