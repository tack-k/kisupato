import {computed, ref} from "vue";


export default function useTagAction(tags, form) {

    const isTagsOpen = ref(false)
    const toggleTagsOpen = () => {
        isTagsOpen.value = !isTagsOpen.value
    }

    const closeTags = () => isTagsOpen.value = false

    const newTags = ref([])

    //表示させるタグの監視
    const displayTags = computed(() => {
        return newTags
    })

    //タグ選択時に追加・リストから削除
    const getSelectedTag = (index) => {
        newTags.value.push({
            'id': tags[index].id,
            'name': tags[index].name,
        })
        form.tag.push(tags[index].id)
        tags.splice(index, 1)
        closeTags()
    }

    //タグの選択
    const searchTags = computed(() => {
        const filteredTags = ref([])

        tags.forEach(tag => {
            filteredTags.value.push({
                'id': tag.id,
                'name': tag.name
            })

        })

        if (filteredTags.value.length === 0) {
            filteredTags.value.push({
                'id': '',
                'name': '該当項目がありません'
            })
            isNoTag.value = true
        }

        return filteredTags
    })

    const isNoTag = ref(false)

    //タグの削除
    const deleteTag = (index) => {
        tags.push({
            'id': newTags.value[index].id,
            'name': newTags.value[index].name,
        })
        sortTag()
        newTags.value.splice(index, 1)
        form.tag.splice(index, 1)
    }

    //タグをid順にソート
    const sortTag = () => {
        tags.sort((a, b) => {
            if (a.id > b.id) {
                return 1;
            } else {
                return -1;
            }
        })
    }


    return {
        isTagsOpen,
        toggleTagsOpen,
        closeTags,
        getSelectedTag,
        searchTags,
        isNoTag,
        displayTags,
        deleteTag,
    }
}
