<?php

   include_once('phpreport/web/services/WebServicesFunctions.php');
   include_once('phpreport/model/facade/UsersFacade.php');
   include_once('phpreport/model/vo/AreaHistoryVO.php');

    $parser = new XMLReader();

    $request = trim(file_get_contents('php://input'));

    /*$request = '<?xml version="1.0" encoding="ISO-8859-15"?><areaHistories><areaHistory><userId>81</userId><areaId>1</areaId><init format="Y-m-d">2009-06-01</init><end format="Y-m-d">2009-12-01</end></areaHistory><areaHistory><userId>81</userId><areaId>2</areaId><init format="Y-m-d">2009-01-01</init><end format="Y-m-d">2009-06-01</end></areaHistory></areaHistories>';*/

    $parser->XML($request);

    do {

        $parser->read();

        if ($parser->name == 'areaHistories')
        {

            $sid = $parser->getAttribute("sid");

            $parser->read();

        }

        /* We check authentication and authorization */
        require_once('phpreport/util/LoginManager.php');

        $user = LoginManager::isLogged($sid);

        if (!user)
        {
            $string = "<return service='createAreaHistories'><error id='2'>You must be logged in</error></return>";
            break;
        }

        if (!LoginManager::isAllowed($sid))
        {
            $string = "<return service='createAreaHistories'><error id='3'>Forbidden service for this User</error></return>";
            break;
        }

        do {

            //print ($parser->name . "\n");

            if ($parser->name == "areaHistory")
            {

                $areaHistoryVO = new AreaHistoryVO();

                $userAssignGroups = array();

                $parser->read();

                while ($parser->name != "areaHistory") {

                    //print ($parser->name . "\n");

                    switch ($parser->name ) {

                        case "areaId":$parser->read();
                                if ($parser->hasValue)
                                {
                                    $areaHistoryVO->setAreaId($parser->value);
                                    $parser->next();
                                    $parser->next();
                                }
                                break;

                        case "init":    $dateFormat = $parser->getAttribute("format");
                                if (is_null($dateFormat))
                                    $dateFormat = "Y-m-d";
                                $parser->read();
                                if ($parser->hasValue)
                                {
                                    $date = $parser->value;
                                    $dateParse = date_parse_from_format($dateFormat, $date);
                                    $date = "{$dateParse['year']}-{$dateParse['month']}-{$dateParse['day']}";
                                    $areaHistoryVO->setInitDate(date_create($date));
                                    $parser->next();
                                    $parser->next();
                                }
                                break;

                        case "end":    $dateFormat = $parser->getAttribute("format");
                                if (is_null($dateFormat))
                                    $dateFormat = "Y-m-d";
                                $parser->read();
                                if ($parser->hasValue)
                                {
                                    $date = $parser->value;
                                    $dateParse = date_parse_from_format($dateFormat, $date);
                                    $date = "{$dateParse['year']}-{$dateParse['month']}-{$dateParse['day']}";
                                    $areaHistoryVO->setEndDate(date_create($date));
                                    $parser->next();
                                    $parser->next();
                                }
                                break;

                        case "userId":$parser->read();
                                if ($parser->hasValue)
                                {
                                    $areaHistoryVO->setUserId($parser->value);
                                    $parser->next();
                                    $parser->next();
                                }
                                break;

                        default:    $parser->next();
                                break;

                    }

                }

                $createAreaHistories[] = $areaHistoryVO;

            }

        } while ($parser->read());

        //var_dump($createUsers);


        if (count($createAreaHistories) >= 1)
            foreach((array)$createAreaHistories as $areaHistory)
            {
                if (UsersFacade::CreateAreaHistory($areaHistory) == -1)
                {
                    $string = "<return service='createAreaHistories'><error id='1'>There was some error while creating the area history entries</error></return>";
                    break;
                }
            }



        if (!$string)
        {

            $string = "<return service='createAreaHistories'><ok>Operation Success!</ok><areaHistories>";

            foreach((array) $createAreaHistories as $areaHistory)
            {
                $string = $string . "<areaHistory><id>{$areaHistory->getId()}</id><areaId>{$areaHistory->getAreaId()}</areaId><init format='Y-m-d'>{$areaHistory->getInitDate()->format('Y-m-d')}</init><end format='Y-m-d'>{$areaHistory->getEndDate()->format('Y-m-d')}</end></areaHistory>";
            }

            $string = $string . "</areaHistories></return>";

        }

    } while (false);


    // make it into a proper XML document with header etc
    $xml = simplexml_load_string($string);

   // send an XML mime header
    header("Content-type: text/xml");

   // output correctly formatted XML
    echo $xml->asXML();
