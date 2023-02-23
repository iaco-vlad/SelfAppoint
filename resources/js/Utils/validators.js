export const passwordValidator = {
    regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/,
    message: 'The password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number.'
}

export const emailValidator = {
    regex: /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
    message: 'Please enter a valid email address.'
}

export const phoneNumberValidator = {
    regex: /^1?[-. ]?(\(\d{3}\)|\d{3})[-. ]?\d{3}[-. ]?\d{4}$/,
    message: 'Please enter a valid phone number.'
}

export const nameValidator = {
    regex: /^[A-Za-z\s]{1,50}$/,
    message: 'The name should contain only characters.'
}

export const titleValidator = {
    regex: /^[A-Za-z\s]{1,50}$/,
    message: 'The title should contain only characters.'
}
