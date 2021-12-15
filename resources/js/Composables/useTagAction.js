import {computed, ref} from "vue";


export default function useTagAction(tags, form) {
console.log(tags)
    const NO_RESULTS = -1

    const isTagsOpen = ref(false)
    const toggleTagsOpen = () => {
        isTagsOpen.value = !isTagsOpen.value
    }

    const closeTags = () => isTagsOpen.value = false

    const Tags = ref([])
    const displayTags = computed(() => {
       return Tags
    })

    const getSelectedTag = (index) => {
        Tags.value.push(tags[index].name)
        tags.splice(index, 1)
        closeTags()
    }


    const searchTags = computed(() => {
        const filteredTags = ref([])

        tags.forEach(tag => {
            if (tag.name.indexOf(form.tag) !== NO_RESULTS) {
                filteredTags.value.push(tag.name)
            }
        })

        if (filteredTags.value.length === 0) {
            filteredTags.value.push('該当項目がありません')
            isNoTag.value = true
        }

        return filteredTags
    })

    const isNoTag = ref(false)

    return {
        isTagsOpen,
        toggleTagsOpen,
        closeTags,
        getSelectedTag,
        searchTags,
        isNoTag,
        displayTags,
    }
}
