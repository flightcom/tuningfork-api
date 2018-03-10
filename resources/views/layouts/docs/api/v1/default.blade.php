<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        @include('includes.docs.api.v1.head')
    </head>
    <body>

        <div class="container">
            <div class="row">
                <div class="col-3" id="sidebar">
                    <div class="column-content">
                        <div class="search-header">
                            <img src="/assets/docs/api.v1/img/f2m2_logo.svg" class="logo" alt="Logo" />
                            <input id="search" type="text" placeholder="Search">
                        </div>
                        <ul id="navigation">

                            <li><a href="#introduction">Introduction</a></li>

                            

                            <li>
                                <a href="#Errors">Errors</a>
                                <ul>
									<li><a href="#Errors_store">store</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#Auth">Auth</a>
                                <ul>
									<li><a href="#Auth_login">login</a></li>

									<li><a href="#Auth_whoAmI">whoAmI</a></li>

									<li><a href="#Auth_logout">logout</a></li>

									<li><a href="#Auth_register">register</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#Password">Password</a>
                                <ul>
									<li><a href="#Password_sendResetLinkEmail">sendResetLinkEmail</a></li>

									<li><a href="#Password_reset">reset</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#Users">Users</a>
                                <ul>
									<li><a href="#Users_index">index</a></li>

									<li><a href="#Users_show">show</a></li>

									<li><a href="#Users_update">update</a></li>

									<li><a href="#Users_destroy">destroy</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#Posts">Posts</a>
                                <ul>
									<li><a href="#Posts_index">index</a></li>

									<li><a href="#Posts_store">store</a></li>

									<li><a href="#Posts_show">show</a></li>

									<li><a href="#Posts_update">update</a></li>

									<li><a href="#Posts_destroy">destroy</a></li>
</ul>
                            </li>


                            <li>
                                <a href="#Devices">Devices</a>
                                <ul>
									<li><a href="#Devices_index">index</a></li>

									<li><a href="#Devices_store">store</a></li>

									<li><a href="#Devices_show">show</a></li>

									<li><a href="#Devices_update">update</a></li>

									<li><a href="#Devices_destroy">destroy</a></li>
</ul>
                            </li>


                        </ul>
                    </div>
                </div>
                <div class="col-9" id="main-content">

                    <div class="column-content">

                        @include('includes.docs.api.v1.introduction')

                        <hr />

                                                

                                                <a href="#" class="waypoint" name="Errors"></a>
                        <h2>Errors</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="Errors_store"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>store</h3></li>
                            <li>api/v1/error/log</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Store a newly created resource in storage.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc">The type of error can be defined on the backend constants

Current types are: backend, web, mobile</p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/error/log" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">The type of error</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">message</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">The error message</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="message">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">stack_trace</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">The stack trace</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="stack_trace">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="Auth"></a>
                        <h2>Auth</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="Auth_login"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>login</h3></li>
                            <li>api/v1/login</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc"></p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/login" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">email</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">required</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="email">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">password</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">required</div>
                                <div class="parameter-value">
                                    <input type="password" class="parameter-value-text" name="password">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="Auth_whoAmI"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>whoAmI</h3></li>
                            <li>api/v1/whoami</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc"></p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/whoami" type="GET">
                          <div class="endpoint-paramenters">
                            
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="Auth_logout"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>logout</h3></li>
                            <li>api/v1/logout</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc"></p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/logout" type="GET">
                          <div class="endpoint-paramenters">
                            
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="Auth_register"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>register</h3></li>
                            <li>api/v1/register</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc"></p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/register" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">email</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">required</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="email">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first_name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">optional</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first_name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">last_name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">optional</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="last_name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">password</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">required</div>
                                <div class="parameter-value">
                                    <input type="password" class="parameter-value-text" name="password">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">password_confirmation</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">required</div>
                                <div class="parameter-value">
                                    <input type="password" class="parameter-value-text" name="password_confirmation">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="Password"></a>
                        <h2>Password</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="Password_sendResetLinkEmail"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>sendResetLinkEmail</h3></li>
                            <li>api/v1/password/email</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Send a reset link to the given user.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/password/email" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">email</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">required</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="email">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="Password_reset"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>reset</h3></li>
                            <li>api/v1/password/reset</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Reset the given user's password.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/password/reset" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">email</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">required</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="email">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">required</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">password</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">required</div>
                                <div class="parameter-value">
                                    <input type="password" class="parameter-value-text" name="password">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">password_confirmation</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">required</div>
                                <div class="parameter-value">
                                    <input type="password" class="parameter-value-text" name="password_confirmation">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="Users"></a>
                        <h2>Users</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="Users_index"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>index</h3></li>
                            <li>api/v1/users</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Display a listing of the resource.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/users" type="GET">
                          <div class="endpoint-paramenters">
                            
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="Users_show"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>show</h3></li>
                            <li>api/v1/users/{user}</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Display the specified resource.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/users/{user}" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">user</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">The user id</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="Users_update"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>update</h3></li>
                            <li>api/v1/users/{user}</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Update the specified resource in storage.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/users/{user}" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">email</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">optional</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="email">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">first_name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">optional</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="first_name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">last_name</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">optional</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="last_name">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">password</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">optional</div>
                                <div class="parameter-value">
                                    <input type="password" class="parameter-value-text" name="password">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">password_confirmation</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">optional if password not set</div>
                                <div class="parameter-value">
                                    <input type="password" class="parameter-value-text" name="password_confirmation">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">status</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">optional</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="status">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">user</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">The user id</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="Users_destroy"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>DELETE</h2></li>
                            <li><h3>destroy</h3></li>
                            <li>api/v1/users/{user}</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Remove the specified resource from storage.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/users/{user}" type="DELETE">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">user</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">The user id</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="user">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="DELETE"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="Posts"></a>
                        <h2>Posts</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="Posts_index"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>index</h3></li>
                            <li>api/v1/posts</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Display a listing of the resource.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/posts" type="GET">
                          <div class="endpoint-paramenters">
                            
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="Posts_store"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>store</h3></li>
                            <li>api/v1/posts</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Store a newly created resource in storage.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/posts" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">title</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">required</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="title">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">text$content</div>
                                <div class="parameter-type">\text</div>
                                <div class="parameter-desc">required</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="text$content">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="Posts_show"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>show</h3></li>
                            <li>api/v1/posts/{post}</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Display the specified resource.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/posts/{post}" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">post</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">The post id</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="post">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="Posts_update"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>update</h3></li>
                            <li>api/v1/posts/{post}</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Update the specified resource in storage.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/posts/{post}" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">title</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">required</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="title">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">text$content</div>
                                <div class="parameter-type">\text</div>
                                <div class="parameter-desc">required</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="text$content">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">post</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">The post id</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="post">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="Posts_destroy"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>DELETE</h2></li>
                            <li><h3>destroy</h3></li>
                            <li>api/v1/posts/{post}</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Remove the specified resource from storage.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/posts/{post}" type="DELETE">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">post</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">The post id</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="post">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="DELETE"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>
                        

                                                <a href="#" class="waypoint" name="Devices"></a>
                        <h2>Devices</h2>
                        <p></p>

                        
                        <a href="#" class="waypoint" name="Devices_index"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>index</h3></li>
                            <li>api/v1/devices</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Display a listing of the resource.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/devices" type="GET">
                          <div class="endpoint-paramenters">
                            
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="Devices_store"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>POST</h2></li>
                            <li><h3>store</h3></li>
                            <li>api/v1/devices</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Register a new Device.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/devices" type="POST">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">userId</div>
                                <div class="parameter-type">integer</div>
                                <div class="parameter-desc">required</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="userId">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">required</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">required : in ['ios','android']</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">uuid</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">required</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="uuid">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="POST"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="Devices_show"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>GET</h2></li>
                            <li><h3>show</h3></li>
                            <li>api/v1/devices/{device}</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Display the specified resource.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/devices/{device}" type="GET">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">device</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">The device id</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="device">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="GET"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="Devices_update"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>PUT</h2></li>
                            <li><h3>update</h3></li>
                            <li>api/v1/devices/{device}</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Update the specified resource in storage.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/devices/{device}" type="PUT">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">uuid</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">required</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="uuid">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">type</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">required</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="type">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">token</div>
                                <div class="parameter-type">string</div>
                                <div class="parameter-desc">required</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="token">
                                </div>
                              </li>
                             <li>
                                <div class="parameter-name">device</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">The device id</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="device">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="PUT"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>

                        <a href="#" class="waypoint" name="Devices_destroy"></a>
                        <div class="endpoint-header">
                            <ul>
                            <li><h2>DELETE</h2></li>
                            <li><h3>destroy</h3></li>
                            <li>api/v1/devices/{device}</li>
                          </ul>
                        </div>

                        <div>
                          <p class="endpoint-short-desc">Remove the specified resource from storage.</p>
                        </div>
                       <!--  <div class="parameter-header">
                             <p class="endpoint-long-desc"></p>
                        </div> -->
                        <form class="api-explorer-form" uri="api/v1/devices/{device}" type="DELETE">
                          <div class="endpoint-paramenters">
                            <h4>Parameters</h4>
                            <ul>
                              <li class="parameter-header">
                                <div class="parameter-name">PARAMETER</div>
                                <div class="parameter-type">TYPE</div>
                                <div class="parameter-desc">DESCRIPTION</div>
                                <div class="parameter-value">VALUE</div>
                              </li>
                                                           <li>
                                <div class="parameter-name">device</div>
                                <div class="parameter-type">int</div>
                                <div class="parameter-desc">The device id</div>
                                <div class="parameter-value">
                                    <input type="text" class="parameter-value-text" name="device">
                                </div>
                              </li>

                            </ul>
                          </div>
                           <div class="generate-response" >
                              <!-- <input type="hidden" name="_method" value="DELETE"> -->
                              <input type="submit" class="generate-response-btn" value="Generate Example Response">
                          </div>
                        </form>
                        <hr>


                    </div>
                </div>
            </div>
        </div>


    </body>
</html>
