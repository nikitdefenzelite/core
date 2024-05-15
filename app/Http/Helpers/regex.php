<?php
/**
 *
 * @category ZStarter
 *
 * @ref     Defenzelite product
 * @author  <Defenzelite hq@defenzelite.com>
 * @license <https://www.defenzelite.com Defenzelite Private Limited>
 * @version <zStarter: 202402-V2.0>
 * @link    <https://www.defenzelite.com>
 */


 function regex($key, $filter = 0)
 {
     $regex_patterns = [
         'name' => [
             'pattern' => '[a-zA-Z ]+',
             'message' => 'Please enter a valid name (only alphabets and spaces allowed)',
         ],
         'title' => [
             'pattern' => '[a-zA-Z ]+',
             'message' => 'Please enter a valid name (only alphabets and spaces allowed)',
         ],
         
         'email' => [
             'pattern' => '[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}',
             'message' => 'Please enter a valid email address',
         ],
         'phone_number' => [
             'pattern' => '\+?\d[\d-]{7,}\d',
             'message' => 'Please enter a valid phone number',
         ],
         'date' => [
             'pattern' => '\d{4}-\d{2}-\d{2}',
             'message' => 'Please enter a valid date in YYYY-MM-DD format',
         ],
         'password' => [
             'pattern' => '(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@$&!])[A-Za-z\d@$&!]{8,}',
             'message' => 'Please ensure your password contains at least one digit, one lowercase letter, one uppercase letter, one special character (@, $, &, or !), and is at least 8 characters long.',
         ],
         'postcode' => [
             'pattern' => '\d{5}(-\d{4})?',
             'message' => 'Please enter a valid postcode',
         ],
         'url' => [
             'pattern' => '(https?|ftp):\/\/[^\s\/$.?#].[^\s]*i',
             'message' => 'Please enter a valid URL',
         ],
         'username' => [
             'pattern' => '[a-zA-Z0-9_]{3,20}',
             'message' => 'Username must be between 3 and 20 characters long and contain only alphanumeric characters and underscores',
         ],
         'ip_address' => [
             'pattern' => '((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$|^([0-9a-fA-F]{1,4}:){7,7}[0-9a-fA-F]{1,4}$|^([0-9a-fA-F]{1,4}:){1,7}:?$|^([0-9a-fA-F]{1,4}:){1,6}:[0-9a-fA-F]{1,4}$|^([0-9a-fA-F]{1,4}:){1,5}(:[0-9a-fA-F]{1,4}){1,2}$|^([0-9a-fA-F]{1,4}:){1,4}(:[0-9a-fA-F]{1,4}){1,3}$|^([0-9a-fA-F]{1,4}:){1,3}(:[0-9a-fA-F]{1,4}){1,4}$|^([0-9a-fA-F]{1,4}:){1,2}(:[0-9a-fA-F]{1,4}){1,5}$|^[0-9a-fA-F]{1,4}:((:[0-9a-fA-F]{1,4}){1,6})',
             'message' => 'Please enter a valid IP address',
         ],
         'hex_color' => [
             'pattern' => '#?([a-f0-9]{6}|[a-f0-9]{3})i',
             'message' => 'Please enter a valid hexadecimal color code',
         ],
         'credit_card' => [
             'pattern' => '((4\d{3})|(5[1-5]\d{2})|(6011))[- ]?\d{4}[- ]?\d{4}[- ]?\d{4}|3[4,7][\d]{13}',
             'message' => 'Please enter a valid credit card number',
         ],

         'zip_code' => [
             'pattern' => '\d{5}(?:[-\s]\d{4})?',
             'message' => 'Please enter a valid ZIP code',
         ],
         'gst' => [
             'pattern' => '\d{2}[a-zA-Z]{5}\d{4}[a-zA-Z]{1}\d[Z]{1}[a-zA-Z\d]{1}',
             'message' => 'Please enter a valid GST (Goods and Services Tax) number',
         ],
         'pan' => [
             'pattern' => '[A-Z]{5}[0-9]{4}[A-Z]{1}',
             'message' => 'Please enter a valid PAN (Permanent Account Number)',
         ],
         'tan' => [
             'pattern' => '[A-Z]{4}[0-9]{5}[A-Z]{1}',
             'message' => 'Please enter a valid TAN (Tax Deduction and Collection Account Number)',
         ],
         'driving_license' => [
             'pattern' => '[A-Z]{2}-\d{13}',
             'message' => 'Please enter a valid Indian Driving Licence number',
         ],
         'age' => [
             'pattern' => '1[89]|[2-9]\d',
             'message' => 'Please enter a valid age (18 years and above)',
         ],
         'gender' => [
             'pattern' => '(male|female|other)',
             'message' => 'Please enter a valid gender (male, female, or other)',
         ],
         'dob' => [
             'pattern' => '(19|20)\d{2}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])',
             'message' => 'Please enter a valid date of birth (YYYY-MM-DD format)',
         ],
         'address' => [
            'pattern' => '[a-zA-Z0-9\s.,#\-]+',
            'message' => 'Please enter a valid address.',
        ],
        'pin_code' => [
            'pattern' => '\d{5}(?:[-\s]?\d{4})?',
            'message' => 'Please enter a valid PIN code.',
        ],

        'code' => [
            'pattern' => '[a-zA-Z\-]+',
            'message' => 'Please enter a valid code consisting of letters and hyphens only.',
        ],
        'country_name' => [
            'pattern' => '[a-zA-Z\s-]+',
            'message' => 'Please enter a valid country name',
        ],

        'amount' => [
            'pattern' => '\d+(\.\d{1,2})?e?',
            'message' => 'Please enter a valid code consisting of letters, digits, dots, and an optional letter "e".',
        ],
        
        'percentage' => [
            'pattern' => '\d*\.?\d+',
            'message' => 'Please enter a valid non-negative number, including integers or decimals.',
        ],
        'subject' => [
            'pattern' => '[a-zA-Z0-9]*',
            'message' => 'Please enter a alphanumeric.',
        ],
        

        // Admin Slider Pattern
        
        'slider_code' => [
            'pattern' => '[a-z_]+',
            'message' => 'Please enter a valid code consisting of small letters and hyphens only.',
        ],

        // Admin Item

        'item_name' => [
            'pattern' => '[a-zA-Z0-9 ]+',
            'message' => 'Please enter a alphanumeric.',
        ],
        'item_sku' => [
            'pattern' => '[a-zA-Z0-9]*',
            'message' => 'Please enter a alphanumeric.',
        ],




        // Admim FAQ

        'faq_question' => [
            'pattern' => '[a-z_]+',
            'message' => 'Please enter a valid code consisting of small letters and hyphens only.',
        ],

        //  Admin Role 

        'role_name' => [
            'pattern' => '[a-z_]+',
            'message' => 'Please enter a valid code consisting of small letters and hyphens only.',
        ],

        'role_display_name' => [
            'pattern' => '[a-z_]+',
            'message' => 'Please enter a valid code consisting of small letters and hyphens only.',
        ],

        'role_display_name' => [
            'pattern' => '[a-z_]+',
            'message' => 'Please enter a valid code consisting of small letters and hyphens only.',
        ],


     ];
 
     if (isset($regex_patterns[$key])) {
         if ($filter == 0) {
             return $regex_patterns[$key];
         } else {
             $regex_patterns[$key]['pattern'] = '/^' . $regex_patterns[$key]['pattern'] . '$/';
             return $regex_patterns[$key];
         }
     } else {
         return null; // or handle the case where the key is not found
     }
 }

 function validation($key, $filter = 0)
 {
     $validate_patterns = [

        'common_name' => [
            'pattern' => ['minlength' => 5, 'maxlength' => 100, 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 40 characters and a maximum of 100 characters.',
         ],

         'common_phone_number' => [
            'pattern' => ['minlength' => 9, 'maxlength' => 12, 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 9 characters and a maximum of 12 characters.',
         ],
 
         'common_email' => [
            'pattern' => ['minlength' => 10, 'maxlength' => 30, 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 30 characters.',
         ],

         'common_short_description' => [
            'pattern' => ['minlength' => 10, 'maxlength' => 90, 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 40 characters and a maximum of 90 characters.',
         ],
 
         'common_description' => [
            'pattern' => ['minlength' => 10, 'maxlength' => 90, 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 40 characters and a maximum of 90 characters.',
         ],
         
         'common_meta_title' => [
            'pattern' => ['minlength' => 5, 'maxlength' => 90, 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 5 characters and a maximum of 90 characters.',
         ],

         'common_meta_description' => [
            'pattern' => ['minlength' => 40, 'maxlength' => 90, 'mandatory' => ''],
            'message' => 'Please make your input consists of a minimum of 40 characters and a maximum of 90 characters.',
         ],

         'common_meta_keywords' => [
            'pattern' => ['minlength' => 40, 'maxlength' => 90, 'mandatory' => ''],
            'message' => 'Please make your input consists of a minimum of 40 characters and a maximum of 90 characters.',
         ],

         'common_title' => [
            'pattern' => ['minlength' => 5, 'maxlength' => 90, 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 5 characters and a maximum of 90 characters.',
         ],

         'common_amount' => [
            'pattern' => ['minlength' => 0, 'maxlength'=>10,  'mandatory' => 'required'],
            'message' => 'Please enter a valid amount. The amount should consist of digits, optionally separated by commas for thousands, and may contain a decimal point for fractional amounts.',
         ],
         'common_address' => [
            'pattern' => ['minlength' => 10, 'maxlength' => 30, 'mandatory' => ''],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 30 characters.',
         ],

         'common_code' => [
            'pattern' => ['minlength' => 10, 'maxlength' => 30, 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 30 characters.',
         ],

         'common_dob' => [
            'pattern' => ['maxlength' => 90, 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 40 characters and a maximum of 90 characters.',
         ],

         'common_password' => [
            'pattern' => ['minlength' => 4, 'maxlength' => 90, 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 40 characters and a maximum of 90 characters.',
         ],

         'common_quantity' => [
            'pattern' => ['mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 40 characters and a maximum of 90 characters.',
         ],

         'common_percentage' => [
            'pattern' => ['minlength' => 0, 'maxlength' => 100, 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 40 characters and a maximum of 90 characters.',
         ],

         'common_standard' => [
            'pattern' => ['minlength' => 0, 'maxlength' => 1000, 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 1000 characters and a maximum of 90 characters.',
         ],

         // Lead validation

        'lead_email' => [
            'pattern' => ['minlength' => 10, 'maxlength' => 30, 'mandatory' => ''],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 30 characters.',
        ],
        'lead_phone_number' => [
            'pattern' => ['minlength' => 9, 'maxlength' => 12, 'mandatory' => ''],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 30 characters.',
        ],
        'lead_address' => [
            'pattern' => ['minlength' => 10, 'maxlength' => 30, 'mandatory' => ''],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 30 characters.',
        ],
        'lead_remark' => [
            'pattern' => ['minlength' => 10, 'maxlength' => 90, 'mandatory' => ''],
            'message' => 'Please make your input consists of a minimum of 40 characters and a maximum of 90 characters.',
        ],
        
        // Blog validation

        'blog_slug' => [
            'pattern' => ['mandatory' => 'required'],
        ],

        // Admin Template Validation

        'template_subject' => [
            'pattern' => ['minlength' => 10, 'maxlength' => 90, 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 40 characters and a maximum of 90 characters.',
        ],

         'template_type' => [
            'pattern' => ['mandatory' => 'required'],
        ],

         'template_is_permanent' => [
            'pattern' => ['mandatory' => 'required'],
        ],

        // Admin Category validation
        'category_group_level' => [
            'pattern' => ['mandatory' => 'required'],
        ],

        'category_group_permanent' => [
            'pattern' => ['mandatory' => 'required'],
        ],

        'category_group_remark' => [
            'pattern' => ['mandatory' => ''],
        ],

        // Admin Slider Validation
        'slider_code' => [
            'pattern' => [ 'minlength' => '10' , 'maxlength'=> '40' , 'mandatory' => 'required '],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 40 characters.',
        ],
        'slider_headline' => [
            'pattern' => [ 'minlength' => '10' , 'maxlength'=> '40' , 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 40 characters.',
        ],
        'slider_sub_headline' => [
            'pattern' => [ 'minlength' => '10' , 'maxlength'=> '40' , 'mandatory' => ''],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 40 characters.',
        ],
        'slider_remark' => [
            'pattern' => [ 'minlength' => '10' , 'maxlength'=> '40' , 'mandatory' => ''],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 40 characters.',
        ],
        'slider_permanent' => [
            'pattern' => [ 'minlength' => '10' , 'maxlength'=> '40' , 'mandatory' => ''],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 40 characters.',
        ],

        // Admin Paragraph Validation
        'paragraph_code' => [
            'pattern' => [ 'minlength' => '10' , 'maxlength'=> '40' , 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 40 characters.',
        ],
        'paragraph_group' => [
            'pattern' => [ 'minlength' => '10' , 'maxlength'=> '40' , 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 40 characters.',
        ],
        'paragraph_type' => [
            'pattern' => [ 'minlength' => '10' , 'maxlength'=> '40' , 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 40 characters.',
        ],
        'paragraph_permanent' => [
            'pattern' => [ 'minlength' => '10' , 'maxlength'=> '40' , 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 40 characters.',
        ],

        // Admin User Edit Assign Role

        'assign_role' => [
            'pattern' => [ 'mandatory' => 'required'],
        ],

        
        // Admin FAQ Validation
        'faq_category' => [
            'pattern' => [ 'mandatory' => 'required'],
        ],
        'faq_question' => [
            'pattern' => [ 'minlength' => '10' , 'maxlength'=> '40' , 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 40 characters.',
        ],

        // Admin SEO Validation 

        'subscribe_' => [
            'pattern' => [ 'minlength' => '10' , 'maxlength'=> '40' , 'mandatory' => ''],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 40 characters.',
        ],

        // Admin Subscription Validation

        'subscription' => [
            'pattern' => [  'mandatory' => 'required'],
        ],

        'subscription_given_user' => [
            'pattern' => [  'mandatory' => 'required'],
        ],

        'subscription_plan' => [
            'pattern' => [  'mandatory' => 'required'],
            
        ],

        'subscription_date' => [
            'pattern' => [ 'mandatory' => 'required'],
            
        ],

        'subscription_price' => [
            'pattern' => [ 'mandatory' => 'required'],
            
        ],

        // Admin Order Validation

        'order_user' => [
            'pattern' => [ 'mandatory' => 'required'],
        ],

        'order_address' => [
            'pattern' => [ 'mandatory' => 'required'],
        ],
        
        'order_item' => [
            'pattern' => [ 'mandatory' => 'required'],
        ],
        
        'order_qty' => [
            'pattern' =>  [ 'mandatory' => 'required','minlength' =>'0', 'maxlength'=>'1000'],
        ],
        
        'order_discount' => [
            'pattern' =>  [ 'mandatory' => 'required','minlength' =>'0', 'maxlength'=>'8000'],
        ],
        
        'order_shipping_charge' => [
            'pattern' => [ 'mandatory' => 'required','minlength' =>'0', 'maxlength'=>'5000'],
        ],

        // Admin Item Validation

        'item_name' => [
            'pattern' => ['mandatory' => 'required','minlength' =>'5', 'maxlength'=>'5000'],
            'message' => 'Please make your input consists of a minimum of 5 characters and a maximum of 5000 characters.',
        ],
        'item_slug' => [
            'pattern' => ['mandatory' => 'required'],
        ],
        'item_short_description' => [
            'pattern' => ['mandatory' => 'required'],
        ],
        'item_description' => [
            'pattern' => ['mandatory' => 'required'],
        ],
        'item_meta_title' => [
            'pattern' => ['mandatory' => ''],
        ],
        'item_meta_keywords' => [
            'pattern' => ['mandatory' => ''],
        ],
        'item_meta_description' => [
            'pattern' => ['mandatory' => ''],
        ],

        'item_sku' => [
            'pattern' => ['minlength' =>'1', 'maxlength'=>'100', 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 1 characters and a maximum of 100 characters.',
        ],

        'item_category' => [
            'pattern' => [ 'mandatory' => 'required'],
        ],

        'item_sub_category' => [
            'pattern' => [ 'mandatory' => 'required'],
        ],

        'item_sell_price' => [
            'pattern' => [ 'minlength' =>'0', 'maxlength'=>'100', 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 40 characters.',
        ],

        'item_buy_price' => [
            'pattern' => ['minlength' =>'0', 'maxlength'=>'100',  'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 40 characters.',
        ],

        'item_price' => [
            'pattern' => [ 'minlength' =>'0', 'maxlength'=>'100', 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 40 characters.',
        ],

        'item_tax' => [
            'pattern' => [ 'minlength' =>'0', 'maxlength'=>'100', 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 40 characters.',
        ],

        'item_hsn' => [
            'pattern' => [ 'mandatory' => ''],
        ],

        'item_image' => [
            'pattern' => [ 'mandatory' => ''],
        ],

        // Admin Subscription Plans Validation
        
        'subscription_name' => [
            'pattern' => [ 'mandatory' => 'required'],
        ],

        'subscription_duration' => [
            'pattern' => [ 'mandatory' => 'required','minlength' =>'0', 'maxlength'=>'1000' ],
        ],

        'subscriptions_price' => [
            'pattern' => [ 'mandatory' => 'required','minlength' =>'0', 'maxlength'=>'1000'],
        ],

        // Admin Management Validation

        'admin_first_name' => [
            'pattern' => [ 'mandatory' => 'required'],
        ],

        'admin_last_name' => [
            'pattern' => [ 'mandatory' => 'required'],
        ],

        'admin_email' => [
            'pattern' => [ 'mandatory' => 'required'],
        ],

        'admin_phone_number' => [
            'pattern' => [ 'mandatory' => 'required'],
        ],

        'admin_dob' => [
            'pattern' => [ 'mandatory' => 'required'],
        ],

        'admin_password' => [
            'pattern' => [ 'mandatory' => 'required'],
        ],

        // Admin Role Validation

        'role_name' => [
            'pattern' => ['minlength' => '10' , 'maxlength'=> '40' , 'mandatory' => 'required'],
        ],
        
        'display_name' => [
            'pattern' => ['minlength' => '10' , 'maxlength'=> '40' , 'mandatory' => 'required'],
        ],

        'description' => [
            'pattern' => [ 'mandatory' => 'required'],
        ],

        // Admin Permission Validation
        'permission_name' => [
            'pattern' => ['minlength' => '10' , 'maxlength'=> '40' , 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 40 characters.',

        ],

        'permission_assign_role' => [
            'pattern' => ['mandatory' => ''],
        ],

        'group_name' => [
            'pattern' => ['minlength' => '10' , 'maxlength'=> '40' , 'mandatory' => 'required'],
            'message' => 'Please make your input consists of a minimum of 10 characters and a maximum of 40 characters.'
        ],
        
        // Admin Website Enquiries Validation

        'website_enquiries_phone' => [
            'pattern' => [ 'mandatory' => 'required'],
        ],

        'website_subject' => [
            'pattern' => [ 'mandatory' => 'required'],
        ],

        // Admin Support Ticket Validation

        'support_user' => [
            'pattern' => [ 'mandatory' => 'required'],
        ],

        'support_category' => [
            'pattern' => [ 'mandatory' => 'required'],
        ],

        'support_subject' => [
            'pattern' => [ 'mandatory' => 'required'],
        ],

        // Admin Setting Validation

        

        
     ];
 
     if (isset($validate_patterns[$key])) {
         if ($filter == 0) {
             return $validate_patterns[$key];
         } else {
             $validate_patterns[$key]['pattern'] = $validate_patterns[$key]['pattern'];
             return $validate_patterns[$key];
         }
     } else {
         return null; // or handle the case where the key is not found
     }
 }