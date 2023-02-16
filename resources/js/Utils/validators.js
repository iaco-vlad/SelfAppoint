export const passwordValidator = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;

export const emailValidator = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/;

export const phoneNumberValidator = /^1?[-. ]?(\(\d{3}\)|\d{3})[-. ]?\d{3}[-. ]?\d{4}$/;

export const nameValidator = /^[A-Za-z]{1,50}$/;
