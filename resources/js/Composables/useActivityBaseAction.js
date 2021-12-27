import {computed, ref} from "vue";


export default function useActivityBaseAction(activityBases, form) {

    const NO_RESULTS = -1

    const isActivityBasesOpen = ref(false)
    const toggleActivityBasesOpen = () => isActivityBasesOpen.value = !isActivityBasesOpen.value

    const closeActivityBases = () => isActivityBasesOpen.value = false

//   const newActivityBases = ref([])

    //タグ選択時に追加・リストから削除
    const getSelectedActivityBase = (index) => {
        // newActivityBases.value.push(
        // //     {
        // //     'id': activityBases[index].id,
        // //     'area_id': activityBases[index].area_id,
        // //     'name': activityBases[index].name,
        // // }
        // )
        form.activity_base = activityBases[index].name
        activityBases.splice(index, 1)
        closeActivityBases()
    }


    //タグの選択
    const searchActivityBases = computed(() => {
        const filteredActivityBases = ref([])

        activityBases.forEach(activityBase => {
           if(activityBase.name.indexOf(form.activity_base) !== NO_RESULTS) {
               filteredActivityBases.value.push(
                   //     {
                   //     'id': activityBase.id,
                   //     'area_id': activityBase.area_id,
                   //     'name': activityBase.name
                   // }
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

    return {
        isActivityBasesOpen,
        toggleActivityBasesOpen,
        closeActivityBases,
        getSelectedActivityBase,
        searchActivityBases,
        isNoActivityBase,
    }
}
