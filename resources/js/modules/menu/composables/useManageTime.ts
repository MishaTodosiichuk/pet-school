export const timeToMinutes = (timeStr: string): number => {
    const [hours, minutes] = timeStr.split(':').map(Number)
    return hours * 60 + minutes
}

export const getNowMinutes = (): number => {
    const now = new Date()
    return now.getHours() * 60 + now.getMinutes()
}
