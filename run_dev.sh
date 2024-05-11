function runFPM() {
    while true; do
        php-cgi -b 127.0.0.1:60000
    done
}

function runCaddy() {
    caddy run --config caddyfile.dev --adapter caddyfile
}
