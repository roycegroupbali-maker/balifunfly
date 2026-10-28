<?php

return [
    'labels' => [
        'name' => 'Name', 'email' => 'Email', 'phone' => 'Phone / WhatsApp', 'topic' => 'Interested in',
        'message' => 'Message', 'language' => 'Language', 'time' => 'Received',
    ],
    'customer' => [
        'subject' => 'We received your request - :name',
        'greeting' => 'Hello :name,',
        'intro' => 'Thank you for contacting :company. We have received your request and our team will get back to you within one business day.',
        'summary' => 'Your request',
        'faster' => 'Need a faster answer? Chat with us directly:',
        'whatsapp' => 'Chat on WhatsApp',
        'regards' => 'Warm regards,',
        'auto' => 'This is an automatic confirmation. You can reply to this email if you want to add anything.',
    ],
    'admin' => [
        'subject' => '[:site] New request from :customer',
        'title' => 'New request received',
        'intro' => 'A new request was just submitted through the website form.',
        'open' => 'Open in admin panel',
        'reply' => 'Reply to this email to answer the customer directly.',
        'footer' => 'Automatic notification from the :site website.',
    ],
];
