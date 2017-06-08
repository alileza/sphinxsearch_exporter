<?php

$env = getenv();

$host = "localhost";
$port = 9312;
if (isset($env['HOST'])){
  $host = $env['HOST'];
}
if (isset($env['PORT'])){
  $host = $env['PORT'];
}

include 'sphinxapi.php';

$cl = new SphinxClient();
$cl->SetServer($host, $port);
$sphinx_status = $cl->status();
if ($sphinx_status == ""){
    http_response_code(503);
    die($cl->GetLastError());
};

$maps = [];

foreach($sphinx_status as $values){
  $maps[$values[0]] = $values[1];
}

$namespace = "sphinxsearch";

function print_metric($namespace, $key, $value, $desc = ""){
    if ($value == "OFF") {
      $value = 0.0;
    }

    echo ($namespace."_".$key." ". floatval($value)."\r\n");
}
header('Content-Type: text/plain');

print_metric($namespace, "up_seconds", $maps['uptime']);
print_metric($namespace, "connections_count", $maps['connections']);
print_metric($namespace, "maxed_out_count", $maps['maxed_out']);
print_metric($namespace, "command_search_count", $maps['command_search']);
print_metric($namespace, "command_excerpt_count", $maps['command_excerpt']);
print_metric($namespace, "command_update_count", $maps['command_update']);
print_metric($namespace, "command_delete_count", $maps['command_delete']);
print_metric($namespace, "command_keywords_count", $maps['command_keywords']);
print_metric($namespace, "command_persist_count", $maps['command_persist']);
print_metric($namespace, "command_flushattrs_count", $maps['command_flushattrs']);
print_metric($namespace, "agent_connect_count", $maps['agent_connect']);
print_metric($namespace, "agent_retry_count", $maps['agent_retry']);
print_metric($namespace, "queries_count", $maps['queries']);
print_metric($namespace, "dist_queries_count", $maps['dist_queries']);
print_metric($namespace, "query_wall_seconds", $maps['query_wall']);
print_metric($namespace, "query_cpu", $maps['query_cpu']);
print_metric($namespace, "dist_wall_seconds", $maps['dist_wall']);
print_metric($namespace, "dist_local_seconds", $maps['dist_local']);
print_metric($namespace, "dist_wait_seconds", $maps['dist_wait']);
print_metric($namespace, "avg_query_wall", $maps['avg_query_wall']);
print_metric($namespace, "avg_query_cpu", $maps['avg_query_cpu']);
print_metric($namespace, "avg_dist_wall", $maps['avg_dist_wall']);
print_metric($namespace, "avg_dist_local", $maps['avg_dist_local']);
print_metric($namespace, "avg_dist_wait", $maps['avg_dist_wait']);
