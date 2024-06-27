## Prestashop 8 Modules

###  01.- whhelloworld Simple module only has:

```console
extends Module Class
install , uninstall methods
register hook displayHome
```

###  02.- whreinsurance module has:

```console
extends Module Class
install , uninstall methods
register hook displayFooterBefore
register hook actionFrontControllerSetMedia to include css file
```

###  03.- whcallback module has (IMPLEMENTATION CQRS):

```console
extends Module Class
install , uninstall methods
register hook displayFooterBefore , registerGDPRConsent
register hook actionFrontControllerSetMedia to include css file
create a Table of Entity Doctrine Object
create a Symfony Form
create a Controller 
```
