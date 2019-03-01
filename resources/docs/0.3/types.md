<a name="routes-types"></a>
# Routes types

---

- [Routes types](#routes-types)
  - [Route](#route)
    - [Controller method](#controller-method)
    - [Closure](#closure)
  - [Resource](#resource)
  - [View](#view)
  - [Group](#group)
  - [Auth](#auth)

<a name="route"></a>
## Route
<a name="controller-method"></a>
### Controller method

One of the most basic Laravel routes accept a URI and a controller method.

To add this kind of route check **Route** and use the **Add** button:

![image](/img/route.png)

![image](/img/method.png)

*You can also add the new route after a route in the list or inside a group.*

You can use the pen icon to open the edit form:

![image](/img/method-menu.png)

You can change or add :

* method
* name
* middlewares
* regular expression constraint

<a name="closure"></a>
### Closure
The most basic Laravel routes accept a URI and a Closure.

To add this kind of route check **Route** use the **Add** button:

![image](/img/route.png)

You can use the pen icon to open the edit form:

![image](/img/closure-menu.png)

It's almost the same form than controller method one.

<a name="resource"></a>
## Resource
Resource route is a shortcut for a typical "CRUD" routes.

You can create a new resource by selecting the good radio button:

![image](/img/resource.png)

And add on top, afer a route in the list or inside a group.

The form that you get with the pen button has 3 sections :

In the first one you set the resource name and the controller name:

![image](/img/section1.png)

In the second one you may specify a subset of actions the controller should handle instead of the full set of default actions:

![image](/img/section2.png)

In the third one you can override routes names :

![image](/img/section3.png)

<a name="view"></a>
## View
If your route only needs to return a view you may use this route. Select it with the good radio button:

![image](/img/view.png)

And add on top, afer a route in the list or inside a group.

You get the form with the pen button :

![image](/img/view-form.png)

You can set :
- url
- view name
- parameters for the view

<a name="group"></a>
## Group
Route groups allow you to share route attributes, such as middleware or namespaces, across a large number of routes without needing to define those attributes on each individual route.

Select it with the good radio button:

![image](/img/group.png)

And add on top, after a route in the list or inside another group.

<a name="auth"></a>
## Auth
Laravel provides a quick way to scaffold all of the routes and views you need for authentication with an Artisan command. But you must add code for toutes.

Select it with the good radio button:

![image](/img/auth.png)

And add on top, after a route in the list or inside a group.

You get the form with the pen button :

![image](/img/auth-form.png)

There is only one option. Select it if you use the email verification.
