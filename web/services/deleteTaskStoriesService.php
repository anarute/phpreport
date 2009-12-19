<?php

   include_once('phpreport/web/services/WebServicesFunctions.php');
   include_once('phpreport/model/facade/CoordinationFacade.php');
   include_once('phpreport/model/vo/TaskStoryVO.php');

    $parser = new XMLReader();

    $request = trim(file_get_contents('php://input'));

    /*$request = '<?xml version="1.0" encoding="ISO-8859-15"?><taskStories><taskStory><id>5</id></taskStory><taskStory><id>6</id></taskStory></taskStories>';*/

    $parser->XML($request);

    do {

        $parser->read();

        if ($parser->name == 'taskStories')
        {

            $sid = $parser->getAttribute("sid");

            $parser->read();

        }

        /* We check authentication and authorization */
        require_once('phpreport/util/LoginManager.php');

        $user = LoginManager::isLogged($sid);

        if (!user)
        {
            $string = "<return service='deleteTaskStories'><error id='2'>You must be logged in</error></return>";
            break;
        }

        if (!LoginManager::isAllowed($sid))
        {
            $string = "<return service='deleteTaskStories'><error id='3'>Forbidden service for this User</error></return>";
            break;
        }

        do {

            if ($parser->name == "taskStory")
            {

                $taskStoryVO = new TaskStoryVO();

                $parser->read();

                while ($parser->name != "taskStory") {

                    switch ($parser->name) {

                        case "id":$parser->read();
                                if ($parser->hasValue)
                                {
                                    $taskStoryVO->setId($parser->value);
                                    $parser->next();
                                    $parser->next();
                                }
                                break;

                        default:    $parser->next();
                                break;

                    }


                }

                $deleteTaskStories[] = $taskStoryVO;

            }

        } while ($parser->read());


        if (count($deleteTaskStories) >= 1)
            foreach((array)$deleteTaskStories as $taskStory)
                if (CoordinationFacade::DeleteTaskStory($taskStory) == -1)
                {
                    $string = "<return service='deleteTaskStories'><error id='1'>There was some error while deleting the task stories</error></return>";
                    break;
                }


        if (!$string)
        {

            $string = "<return service='deleteTaskStories'><ok>Operation Success!</ok></return>";

        }


    } while (false);


    // make it into a proper XML document with header etc
    $xml = simplexml_load_string($string);

   // send an XML mime header
    header("Content-type: text/xml");

   // output correctly formatted XML
    echo $xml->asXML();
