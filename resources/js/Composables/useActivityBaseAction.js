import {computed, ref} from "vue";


export default function useActivityBaseAction(activityBases, form, initActivityBase) {

    const NO_RESULTS = -1

    const isActivityBasesOpen = ref(false)
    const toggleActivityBasesOpen = () => {
        if (isActivityBasesOpen.value) {
            isActivityBasesOpen.value = false
            closeActivityBases()
            form.activity_base = ''
            displayActivityBase.value = ''
        } else {
            isActivityBasesOpen.value = true
        }
    }

    const closeActivityBases = () => isActivityBasesOpen.value = false


    //項目選択時に入力フォームに追加
    const getSelectedActivityBase = e => {

        if (isNoActivityBase.value) {
            return
        }
        activityBases.forEach(activityBase => {
            if(activityBase.name.indexOf(e.target.innerText) !== NO_RESULTS) {
                form.activity_base = activityBase.id
                displayActivityBase.value = activityBase.name
            }
        })


        closeActivityBases()
    }


    //項目検索機能
    const searchActivityBases = computed(() => {
        const filteredActivityBases = ref([])

        if (isNoActivityBase.value) {
            isNoActivityBase.value = false
        }

        activityBases.forEach(activityBase => {
            if (activityBase.name.indexOf(displayActivityBase.value) !== NO_RESULTS) {
                filteredActivityBases.value.push(
                    activityBase
                )
            }
        })

        if (filteredActivityBases.value.length === 0) {
            filteredActivityBases.value.push({
                'id': '',
                'area_id': '',
                'name': '該当項目がありません'
            })
            isNoActivityBase.value = true
        }

        return filteredActivityBases
    })

    const isNoActivityBase = ref(false)


    // 要素外をクリック時に画面を閉じる
    const onClickOutside = () => {
        form.activity_base = ''
        displayActivityBase.value = ''
        closeActivityBases()
    }

    let displayActivityBase = ref(initActivityBase ?? '')

    return {
        isActivityBasesOpen,
        toggleActivityBasesOpen,
        closeActivityBases,
        getSelectedActivityBase,
        searchActivityBases,
        isNoActivityBase,
        onClickOutside,
        displayActivityBase,
    }
}
