<?php

    $DatabaseJson = file_get_contents("database.json");
    $DatabaseContent = json_decode($DatabaseJson, true);

    $ProvidedLogin = $_GET["Login"];
    $ProvidedPassword = $_GET["Password"];
    $ProvidedMessage = $_GET["Message"];

    //var_dump($DatabaseContent);

    $UserCount = count($DatabaseContent["Users"]);
    $ShouldLogin = false;
    for ($UserIndex = 0; $UserIndex < $UserCount; $UserIndex++)
    {
        if($DatabaseContent["Users"][$UserIndex]["Login"] == $ProvidedLogin)
        {
            if($DatabaseContent["Users"][$UserIndex]["Password"] == $ProvidedPassword)
            {
                $ShouldLogin = true;
                break;
            }
        }
    }

    $MessageCount = count($DatabaseContent["Messages"]);
    for($MessageIndex = 0; $MessageIndex < $MessageCount; $MessageIndex++)
    {
        printf("%s: %s: %s", $DatabaseContent["Messages"][$MessageIndex]["Date"],
                             $DatabaseContent["Messages"][$MessageIndex]["UserLogin"],
                             $DatabaseContent["Messages"][$MessageIndex]["Text"]);
        echo "<br>";
    }


    if($ShouldLogin)
    {
        if($ProvidedMessage != "")
        {
            $Date = date("j F");
            printf("%s: %s: %s", $Date, $ProvidedLogin, $ProvidedMessage);

            $DatabaseContent["Messages"][$MessageCount]["Date"] = $Date;
            $DatabaseContent["Messages"][$MessageCount]["UserLogin"] = $ProvidedLogin;
            $DatabaseContent["Messages"][$MessageCount]["Text"] = $ProvidedMessage;

            file_put_contents("database.json", json_encode($DatabaseContent));
        }

    }
    else
    {
        printf("Wrong login or password");
    }

?>
