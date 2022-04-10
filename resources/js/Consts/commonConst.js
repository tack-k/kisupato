export const commonConst = {
    //活動写真の保存パス
    ACTIVITY_PATH: '/storage/activity_images/',

    //専門人材側プロフィール画像の保存パス
    PROFILE_PATH: '/storage/profile_images/',

    //ユーザー側プロフィール画像の保存パス
    USER_PROFILE_PATH: '/storage/user_profile_images/',

    //初期プロフィール画像
    DEFAULT_PROFILE: 'default_profile.png',

    COMMON_PATH: '/images/common/',

    //依頼リクエストの状態
    REQUEST_APPLYING: '0', //依頼申請中
    REQUEST: '1', //依頼中
    REQUEST_EXAMINATION: '2', //検討中
    REQUEST_FINISHED: '3', //取引完了
    REQUEST_CANCELED: '4', //キャンセル

    //相談状況
    CONSULTATION: '0', //相談中
    CONSULTATION_FINISHED: '1',
    CONSULTATION_CANCELED: '2',

    //アカウント情報
    MEN: 0,
    WOMEN: 1,
    OTHER_GENDER: 2,

    //トップ画面プロフィール最大表示件数
    MAX_PROFILE_COUNT_TOP: 6,

    //レビューコメントの表示文字上限数
    MAX_REVIEW_COUNT: 100,

}

export const userReviewTabs = {
    index: { title: 'レビュー済み', url: 'review.index' },
    yet: { title: '未レビュー', url: 'review.yet' },
}

export const expertReviewTabs = {
    index: { title: 'レビュー済み', url: 'expert.review.index' },
    yet: { title: '未レビュー', url: 'expert.review.yet' },
}
