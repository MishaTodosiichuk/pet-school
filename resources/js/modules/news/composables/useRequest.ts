import {useLoading} from "@/modules/app/composables/useLoading";

export const useRequest = async <T>(
    request: Promise<{ data: { data: T } }>
): Promise<T | null> => {

    const { showLoading, hideLoading } = useLoading()

    await showLoading()

    try {
        const res = await request

        return res.data.data
    } finally {
        hideLoading()
    }
}
