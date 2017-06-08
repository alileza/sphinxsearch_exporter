FROM phpdockerio/php71-cli

COPY index.php /
COPY sphinxapi.php /

CMD ["php", "-S", "0.0.0.0:9217", "/index.php"]
