export interface ContactType {
    code_edrpou?: string,
    zip_code?: string,
    address?: string,
    schedule?: string,
    email?: string,
    phone_number?: string,
    head_institution?: string,
}

export interface ContactResponse {
    data: ContactType
}
