export const useShare = () => {
    const share = (type: 'facebook' | 'telegram' | 'viber' | 'print', newsTitle: string) => {
        const url: string = encodeURIComponent(window.location.href)
        const title: string = encodeURIComponent(newsTitle ?? '')

        switch (type) {
            case 'facebook': {
                window.open(
                    `https://www.facebook.com/sharer/sharer.php?u=${url}`,
                    '_blank'
                )
                break
            }
            case 'telegram': {
                window.open(
                    `https://t.me/share/url?url=${url}&text=${title}`,
                    '_blank'
                )
                break
            }
            case 'viber': {
                window.open(
                    `viber://forward?text=${title}%20${url}`,
                    '_blank'
                )
                break
            }
            case 'print': {
                if (type === 'print') {
                    window.print()
                }
                break
            }
        }
    }
    return { share }
}
