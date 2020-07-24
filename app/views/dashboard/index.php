
<main id = "dashboard">

    <section dir-search-bar>

        <!-- Search Bar -->

    </section>

    <section id="userinfo" class="userinfo" ng-controller="mainController">

        <h1> User: {{user}} | Status: {{stats()}} </h1>

    </section>

    <section ng-view>

        <!--view port for angularjs-->

    </section>

</main>
