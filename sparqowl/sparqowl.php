<?php

require_once('sparqllib.php');

if(php_sapi_name() === 'cli') {
    // do command line tings
    $query = implode(' ', file('query.sparql'));
} else {
    $query = $_POST['query'];
    $endpoint = $_POST['endpoint'];
}

// Load the query...

$query = str_replace(array("\r\n", "\r", "\n", "\t", "  "), ' ', $query);

// Find and resolve OWL blocks
// TODO: Resolve prefixes

preg_match_all("/OWL\s*<(.+)>\s*{\s*(.+)\s*}/", $query, $owls, PREG_SET_ORDER);
foreach($owls as $owl) {
    $result = owl_query($owl[1], $owl[2]);
    if(!$result) {
        print "OWL query failed. World ending.";
        exit;
    }
    $values = parse_owl($result);

    // Replace OWL block with classes
    $query = str_replace($owl[0], $values, $query);
}

print 'Resolved Query: ' . $query . '<br /><br />';

// Run the SPARQL query

$db = sparql_connect($endpoint);
$result = sparql_query($query);
if(!$result) {
    print sparql_errno() . ': ' . sparql_error() . '<br />';
    exit;
}

// Print results

$fields = sparql_field_array($result);

print "Results: <br /><br />";
print "Number of rows: " . sparql_num_rows($result) . "<br />";
while($row = sparql_fetch_array($result)) {
    foreach($fields as $field) {
        print '[' . $field . ']: ' . $row[$field];
    }
    print '<br />';
}

// Perform a remote OWL query
function owl_query($endpoint, $query) {
    $url = $endpoint . '?query=' . urlencode($query);

    $request = curl_init($url);
    curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($request, CURLOPT_HTTPHEADER, array(
        'Accept: application/json'
    ));

    $result = curl_exec($request);
    $info = curl_getinfo($request);

    // TODO: Reasonable error handling
    if($result === '' || $info['http_code'] != 200) {
        return;
    }
    
    curl_close($request);

    return $result;
}

// Turn the OWL query result into a VALUES array
function parse_owl($owl) {
    $data = json_decode($owl, true);
    $values = 'VALUES (?iri ?id) { ';
    foreach($data as $object) {
        $uri = $object['iri']['prefix'] . '#' . $object['iri']['remainder'];
        $values .= '( ' . $uri . '  ' . $object['iri']['remainder'] . ' ) ';
    }
    $values .= '}';

    return $values;
}
