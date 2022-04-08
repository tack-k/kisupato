import { commonConst } from '@/Consts/commonConst'

export default function useCommonAction() {

    const { USER_PROFILE_PATH, COMMON_PATH, DEFAULT_PROFILE } = commonConst

    //表示するユーザープロフィールのパスを設定する
    const setDisplayedProfilePath = (profileImage) => {
       return profileImage === DEFAULT_PROFILE ? COMMON_PATH : USER_PROFILE_PATH;
    }

    return {
        setDisplayedProfilePath,
    }
}
