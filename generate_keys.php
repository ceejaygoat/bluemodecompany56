
<?php
header('Content-Type: application/json');

// Function to generate a random license key
function generateLicenseKey($groupSize = 2, $groups = 3) {
    $key = '';
    for ($i = 0; $i < $groups; $i++) {
        // Generate a random alphanumeric string
        $randomString = strtoupper(bin2hex(random_bytes($groupSize / 2))); // Generates letters
        $randomNumbers = rand(10, 99); // Generates two random numbers
        $key .= $randomString . $randomNumbers; // Append letters and numbers
        if ($i < $groups - 1) {
            $key .= '-'; // Add hyphen except for the last group
        }
    }
    return $key;
}

// Read the input data from the request
$data = json_decode(file_get_contents('php://input'), true);
$numKeys = intval($data['numKeys']);
$expiryDays = intval($data['expiryDays']);
$keys = [];

// Generate the requested number of license keys with expiry dates
for ($i = 0; $i < $numKeys; $i++) {
    $licenseKey = generateLicenseKey(); // Generate the license key
    $expiryDate = date('Y-m-d', strtotime("+$expiryDays days")); // Calculate expiry date
    $keys[] = "$licenseKey - Expires on: $expiryDate"; // Store key with expiry date
}

// Return the generated keys as a JSON response
echo json_encode(['keys' => $keys]);
?>