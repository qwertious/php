<!DOCTYPE html>
<html>
    <head>
        <link href="./style.css" rel="stylesheet">
        <title>Qwertious | Server Test</title>
    </head>
    <body>
        <header class="zero">
            <h1>QWERTIOUS</h1>
        </header>
        <nav class="one">
            <object data="./navlinks.html"></object>
            <!--Navlinks-->
        </nav>
        <h1 class="zero">Server Test</h1>
        <p class="zero">This is a server test for plus.qwertious.org.</p>
        <p><?php
        ini_set('error_reporting', E_ALL ^ E_NOTICE);
        ini_set('display_errors', 1);
        
        // Set time limit to indefinite execution
        set_time_limit(0);
        
        // Set the ip and port we will listen on
        $address = '193.122.145.158';
        $port = 443;
        
        ob_implicit_flush();
        
        // Create a TCP Stream socket
        $sock = socket_create(AF_INET, SOCK_STREAM, 0);
        
        // Bind the socket to an address/port
        socket_bind($sock, $address, $port) or die('Could not bind to address');
        
        // Start listening for connections
        socket_listen($sock);
        
        // Non block socket type
        socket_set_nonblock($sock);
        
        // Clients
        $clients = [];
        
        // Loop continuously
        while (true) {
            // Accept new connections
            if ($newsock = socket_accept($sock)) {
                if (is_resource($newsock)) {
                    // Write something back to the user
                    socket_write($newsock, ">", 1).chr(0);
                    // Non bloco for the new connection
                    socket_set_nonblock($newsock);
                    // Do something on the server side
                    echo "New client connected\n";
                    // Append the new connection to the clients array
                    $clients[] = $newsock;
                }
            }
        
            // Polling for new messages
            if (count($clients)) {
                foreach ($clients AS $k => $v) {
                    // Check for new messages
                    $string = '';
                    if ($char = socket_read($v, 1024)) {
                        $string .= $char;
                    }
                    // New string for a connection
                    if ($string) {
                        echo "$k:$string\n";
                    } else {
                        if ($seconds > 60) {
                            // Ping every 5 seconds for live connections
                            if (false === socket_write($v, 'PING')) {
                                // Close non-responsive connection
                                socket_close($clients[$k]);
                                // Remove from active connections array
                                unset($clients[$k]);
                            }
                            // Reset counter
                            $seconds = 0;
                        }
                    }
                }
            }
        
            sleep(1);
        
            $seconds++;
        }
        
        // Close the master sockets
        socket_close($sock);
        ?></p>
        <footer class="two">
            <object data="./footer.html"></object>
            <!--References-->
            <!--More info-->
            <object data="./navlinks.html"></object>
            <!--Navlinks-->
        </footer>
    </body>
</html>
