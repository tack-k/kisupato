<template>
    <div class="w-2/12 flex items-center flex-col">
        <RegularButton @click.stop="regularAction" class="mb-1">
            {{ regularText }}
        </RegularButton>
        <OutlineButton @click.stop="outlineAction" class="">
            {{ outlineText }}
        </OutlineButton>
    </div>
</template>

<script>
import RegularButton from '@/Components/Buttons/RegularButton'
import OutlineButton from '@/Components/Buttons/OutlineButton'
import { toRefs } from 'vue'

export default {
    name: "DoubleButton",
    components: { OutlineButton, RegularButton },
    props: {
        regularAction: {
            type: Function,
            default: null,
        },
        outlineAction: {
            type: Function,
            default: null,
        },
        regularText: String,
        outlineText: String,
    },
    setup(props) {
        const { regularText, outlineText } = toRefs(props);
        return {
            regularText,
            outlineText,
        }
    }
}
</script>

<style scoped>

</style>
