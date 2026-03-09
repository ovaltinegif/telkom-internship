<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:8000/admin/users");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// Assuming the user has a session cookie from their browser request, I want to bypass auth.
// Actually, it's easier to use Artisan Tinker to execute a full request and get the response content.
// Wait, can we just view the tinker render_test script that did exactly this?
