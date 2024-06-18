<?php

    // All status

const CUSTOM_DOMAIN_SETUP_YES = 1;

const PACKAGE_IS_POPULAR = 1;
const CUSTOM_DOMAIN_SETUP_NO = 0;

const ORDER_PAYMENT_STATUS_PENDING = 0;
const ORDER_PAYMENT_STATUS_PAID = 1;
const ORDER_PAYMENT_STATUS_CANCELLED = 2;

const CUSTOM_DOMAIN_STATUS_PENDING = 0;
const CUSTOM_DOMAIN_STATUS_APPROVED = 1;
const CUSTOM_DOMAIN_STATUS_CANCELLED = 2;
const STATUS_SUCCESS = 1;
const STATUS_REJECT = 3;
const STATUS_ACTIVE = 1;
const STATUS_DRAFT = 2;
const STATUS_DISABLE = 3;
const STATUS_DEACTIVATE = 3;
const STATUS_EXPIRED = 4;

// dynamic fields part start

const TEXT_FIELD_ID = 1;
const TEXTAREA_FIELD_ID = 2;

const REQUIRED_NO = 0;
const REQUIRED_YES = 1;

// dynamic fields part end

// User Role Type
const USER_STATUS_ACTIVE = 1;
const USER_STATUS_INACTIVE = 0;
const USER_STATUS_UNVERIFIED = 2;
const USER_ROLE_SUPER_ADMIN = 1;
const USER_ROLE_ADMIN = 2;
const USER_ROLE_AGENT = 3;
const USER_ROLE_CUSTOMER = 4;

// Message constant
// Message

const PACKAGE_STATUS_ACTIVE = 1;
const PACKAGE_STATUS_INACTIVE = 1;
const PACKAGE_DURATION_TYPE_MONTHLY = 1;
const PACKAGE_DURATION_TYPE_YEARLY = 2;
const SOMETHING_WENT_WRONG = "Something went wrong! Please try again";
const ALREADY_EXISTS_CATEGORY = "Already exists category";
const CREATED_SUCCESSFULLY = "Created Successfully";
const FAVORITES_SUCCESSFULLY = "Image add to favorite list";
const FAVORITES_REMOVE_SUCCESSFULLY = "Image removed from favorite list";
const UPDATED_SUCCESSFULLY = "Updated Successfully";
const SUBMIT_SUCCESSFULLY = "Submit Successfully";
const STATUS_UPDATED_SUCCESSFULLY = "Status Updated Successfully";
const DELETED_SUCCESSFULLY = "Deleted Successfully";
const UPLOADED_SUCCESSFULLY = "Uploaded Successfully";
const DATA_FETCH_SUCCESSFULLY = "Data Fetch Successfully";
const SENT_SUCCESSFULLY = "Sent Successfully";
const PAY_SUCCESSFULLY = "Pay Successfully";
const ASSIGNED_SUCCESSFULLY = "Assigned Successfully";

const SEARCH_FOUND = "Search Found";
const SEARCH_NOT_FOUND = "No Search Found";
const DO_NOT_HAVE_PERMISSION = 7;

// Currency placement
const CURRENCY_SYMBOL_BEFORE=1;
const CURRENCY_SYMBOL_AFTER=2;

// storage driver
const STORAGE_DRIVER_PUBLIC = 'public';
const STORAGE_DRIVER_AWS = 's3';
const STORAGE_DRIVER_WASABI = 'wasabi';
const STORAGE_DRIVER_VULTR = 'vultr';
const STORAGE_DRIVER_DO = 'do';

const ACTIVE = 1;
const INITIATE = 2;
const DEACTIVATE = 0;


const GATEWAY_MODE_LIVE = 1;
const GATEWAY_MODE_SANDBOX = 2;

//Gateway name
const PAYPAL = 'paypal';
const STRIPE = 'stripe';
const RAZORPAY = 'razorpay';
const INSTAMOJO = 'instamojo';
const MOLLIE = 'mollie';
const PAYSTACK = 'paystack';
const SSLCOMMERZ = 'sslcommerz';
const MERCADOPAGO = 'mercadopago';
const FLUTTERWAVE = 'flutterwave';
const BANK = 'bank';
const WALLET = 'wallet';
const PAYMENT_SECTION_ID = 4;
const TRUSTED_PLATFORM_SECTION_ID = 5;
const NEWS_AND_ARTICLES_SECTION_ID = 6;
const GET_IN_TOUCH_SECTION_ID = 7;

const DURATION_TYPE_DAY = 1;
const DURATION_TYPE_MONTH = 2;
const DURATION_TYPE_YEAR = 3;
const DEPOSIT_TYPE_BUY = 1;
const DEPOSIT_TYPE_DEPOSIT = 2;

const ORDER_TYPE_DEPOSIT = 1;
const ORDER_TYPE_HARDWARE = 2;
const ORDER_TYPE_PLAN = 3;

const RETURN_TYPE_FIXED = 1;
const RETURN_TYPE_RANDOM = 2;




const PAGE_ABOUT_US=1;
const PAGE_PRIVACY_POLICY=2;
const PAGE_TERMS_OF_SERVICE=3;
const PAGE_COOKIE_POLICY=4;
const PAGE_REFUND_POLICY=5;

//Ticket Status
const STATUS_PENDING = 0;
const STATUS_OPEND = 0;
const STATUS_INPROGRESS = 1;
const STATUS_CANCELED = 2;
const STATUS_ON_HOLD = 3;
const STATUS_CLOSED = 4;
const STATUS_RESOLVED = 5;
const STATUS_REOPEN = 6;
const STATUS_SUSPENDED = 7;

const TICKET_TYPE_INTERNAL = 1;
const TICKET_TYPE_EXTARNAL = 2;


//Ticket Priority
const GENERALLY = 0;
const HIGH = 1;
const MEDIUM = 2;
const LOW = 3;
const CRITICAL = 4;
const GENERAL = 5;
const URGENT = 6;


