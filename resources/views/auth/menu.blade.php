
<ul class="menu-admin match-height uk-nav-default" uk-nav="multiple: true">

    <!-- users -->
    <li class="uk-parent">
        <a href="#">Users</a>
        <ul class="uk-nav-sub">
            <li><a href="{{ route('admin.users.index') }}">
                    Liste des Users</a>
            </li>
            <li><a href="{{ route('admin.users.create') }}">
                    Ajouter un User</a>
            </li>
        </ul>
    </li>

    <!-- experiences -->
    <li class="uk-parent">
        <a href="#">Experiences</a>
        <ul class="uk-nav-sub">
            <li><a href="{{ route('admin.experiences.index') }}">
                    Liste des Experiences</a>
            </li>
            <li><a href="{{ route('admin.experiences.create') }}">
                    Ajouter une Experience</a>
            </li>
        </ul>
    </li>

    <!-- technologies -->
    <li class="uk-parent">
        <a href="#">Technologies</a>
        <ul class="uk-nav-sub">
            <li><a href="{{ route('admin.technologies.index') }}">
                    Liste des Technologies</a>
            </li>
            <li><a href="{{ route('admin.technologies.create') }}">
                    Ajouter une Technologie</a>
            </li>
        </ul>
    </li>

    <!-- experience technologies -->
    <li class="uk-parent">
        <a href="#">Experience technologies</a>
        <ul class="uk-nav-sub">
            <li><a href="{{ route('admin.experience_technologies.index') }}">
                    Liste des Experience technologies</a>
            </li>
            <li><a href="{{ route('admin.experience_technologies.create') }}">
                    Ajouter une Experience technologie</a>
            </li>
        </ul>
    </li>

    <!-- skills -->
    <li class="uk-parent">
        <a href="#">Skills</a>
        <ul class="uk-nav-sub">
            <li><a href="{{ route('admin.skills.index') }}">
                    Liste des Skills</a>
            </li>
            <li><a href="{{ route('admin.skills.create') }}">
                    Ajouter un Skill</a>
            </li>
        </ul>
    </li>

    <!-- modules -->
    <li class="uk-parent">
        <a href="#">Modules</a>
        <ul class="uk-nav-sub">
            <li><a href="{{ route('admin.modules.index') }}">
                    Liste des Modules</a>
            </li>
            <li><a href="{{ route('admin.modules.create') }}">
                    Ajouter un Module</a>
            </li>
        </ul>
    </li>

    <!-- module skills -->
    <li class="uk-parent">
        <a href="#">Module skills</a>
        <ul class="uk-nav-sub">
            <li><a href="{{ route('admin.module_skills.index') }}">
                    Liste des Module skills</a>
            </li>
            <li><a href="{{ route('admin.module_skills.create') }}">
                    Ajouter un Module skill</a>
            </li>
        </ul>
    </li>

    <!-- works -->
    <li class="uk-parent">
        <a href="#">Works</a>
        <ul class="uk-nav-sub">
            <li><a href="{{ route('admin.works.index') }}">
                    Liste des Works</a>
            </li>
            <li><a href="{{ route('admin.works.create') }}">
                    Ajouter un Work</a>
            </li>
        </ul>
    </li>

    <!-- illustrations -->
    <li class="uk-parent">
        <a href="#">Illustrations</a>
        <ul class="uk-nav-sub">
            <li><a href="{{ route('admin.illustrations.index') }}">
                    Liste des Illustrations</a>
            </li>
            <li><a href="{{ route('admin.illustrations.create') }}">
                    Ajouter une Illustration</a>
            </li>
        </ul>
    </li>

</ul>
