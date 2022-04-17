import { commonConst } from '@/Consts/commonConst'
import moment from 'moment'

export default function useCommonAction() {

    const { USER_PROFILE_PATH, COMMON_PATH, DEFAULT_PROFILE } = commonConst

    //表示するユーザープロフィールのパスを設定する
    const setDisplayedProfilePath = (profileImage) => {
       return profileImage === DEFAULT_PROFILE ? COMMON_PATH : USER_PROFILE_PATH;
    }

    moment.locale('ja', {
        weekdays: ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'],　
        weekdaysShort: ['日','月','火','水','木','金','土']
    })

    //日付のフォーマット
    const formatDate = (date) => {
        return moment(date).format('YYYY年MM月DD日')
    }

    //日時のフォーマット
    const formatDateTime = (date) => {
        return moment(date).format('YYYY年MM月DD日(ddd) HH時mm分')
    }

    return {
        setDisplayedProfilePath,
        formatDate,
        formatDateTime,
    }
}
