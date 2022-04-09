import { commonConst } from '@/Consts/commonConst'

export default function useChatroomCardAction() {
    const {
        REQUEST_EXAMINATION,
        REQUEST,
        REQUEST_CANCELED,
        REQUEST_FINISHED,
        REQUEST_APPLYING,
        CONSULTATION,
        CONSULTATION_FINISHED,
        CONSULTATION_CANCELED,
    } = commonConst;

    //相談状態によるカラー設定
    const setConsultationColor = (status) => {
        switch (status) {
            case CONSULTATION:
                return 'running-status'
                break
            case CONSULTATION_FINISHED:
                return 'finished-status'
                break
            case CONSULTATION_CANCELED:
                return 'canceled-status'
                break
        }
    }

    //依頼状態によるカラー設定
    const setRequestColor = (status) => {
        switch (status) {
            case REQUEST_APPLYING:
                return 'applying-status'
                break
            case REQUEST:
                return 'running-status'
                break
            case REQUEST_FINISHED:
                return 'finished-status'
                break
            case REQUEST_CANCELED:
                return 'canceled-status'
                break
        }
    }

    //依頼状態を表示するか否か
    const isShowRequestName = (chatroom) => {
        if(chatroom.request_status === REQUEST_EXAMINATION) {
            return false
        } else if (chatroom.request_status === REQUEST_CANCELED && chatroom.consultation_status === CONSULTATION_CANCELED) {
            return false
        } else {
            return true
        }
    }

    //チャットルームのステータスを送信する
    const submitChatroomStatus = (message, requestStatus, consultationStatus, form, url) => {
        form.request_status = requestStatus
        form.consultation_status = consultationStatus
        if (confirm(message)) {
            form.post(url)
        }
    }

    return {
        isShowRequestName,
        setRequestColor,
        setConsultationColor,
        submitChatroomStatus,
    }
}
