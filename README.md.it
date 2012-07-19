


L'obiettivo di questo bundle è di creare una configurabile monitorazzione di ciò che sta accadendo in produzione:

I Collector sono delle Classi che collezionano dati, hanno un tag 'collector'
cosi che possono essere chiamati ad ogni Request/Response/Exception

Il flusso è questo:

1. Un listener `StatsDCollectorListener` è sottoscritto agli eventi del kernel,
2. Quando è invocato chiama il `StatsDCollectorService` passandogli Response Request Exception
3. `StatsDCollectorService` chiama tutti i collettori registrati di tipo `StatsCollectorInterface`
4. `StatsDCollectorService` invia tutti i dati al StatsDClientService
5. StatsDClientService provvede ad inviarlo al server
6. sul tuo graphite potrai avere un monitor di tutti i dati e di tutto quello che succede nella tua symfony2 application


## How To create a new Collector

## How to register a new Collector

## TODO list

1. create a library with StatDClient

2. travis

3. composer



        // User login/logout
        //https://github.com/kjszymanski/FOSUserBundle/blob/8be9091263da7ba30601ced352af04de7c10b0b9/Controller/RegistrationController.php
        // Page Visit, Page Unique.
        // doctrine: insert-update-delete
        // kernel exception
        // Email sent
        // Listener for CustomEvent
        // Cache vs query