
<div>

    <!-- Group 1 -->
    <div class="uk-card uk-card-default c-panel">
        <div class="uk-card-header">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
                <div class="uk-width-auto">
                    <img class="uk-border-circle" width="60" height="60" src="{{ asset('storage/0034-library.png') }}" alt="icone">
                </div>
                <div class="uk-width-expand">
                    <h3 class="uk-card-title uk-margin-remove-bottom uk-text-primary">Dashboard</h3>
                    <p class="uk-text-meta uk-margin-remove-top">All menus in one place</p>
                </div>
            </div>
        </div>

        <div class="uk-card-body">

            <div class="uk-flex uk-flex-left uk-flex-row uk-flex-wrap uk-flex-wrap-around uk-background-muted">

                <!-- CPanel User -->
                <div class="uk-card uk-card-default uk-card-body uk-flex-auto">

                    <h3 class="uk-card-title"><span uk-icon="icon:users; ratio:1"></span> Users</h3>

                    <div>
                        <span uk-icon="icon:list; ratio:1"></span>
                        <a href="{{ route('admin.users.index') }}" class="uk-button uk-button-text">
                            Liste des Users
                        </a>

                        <br/>
                        <span uk-icon="icon:plus-circle; ratio:1"></span>
                        <a href="{{ route('admin.users.create') }}" class="uk-button uk-button-text">
                            Ajouter un User
                        </a>
                    </div>

                    <div class="uk-text-meta uk-float-right">
                        <span>?-</span>
                        <a href="#" class="uk-button uk-button-text" uk-toggle="target: #aide-user">
                            Aide
                        </a>
                    </div>

                    <!-- Modal to help for Users -->
                    <div id="aide-user" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body">
                            <button class="uk-modal-close-default" type="button" uk-close></button>
                            <h2 class="uk-modal-title">Users</h2>

                            <p>A propos de &#171; Users &#187;</p>
                            <ul>
                                <li>
                                    Pour enregistrer un nouveau user, cliquer sur <strong>&#171; Ajouter un user &#187;</strong>
                                </li>
                                <li>
                                    Pour voir la liste ou modifier les users enregistrés, cliquer sur <strong>&#171; Liste des users &#187;</strong>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                <!-- CPanel Experience -->
                <div class="uk-card uk-card-default uk-card-body uk-flex-auto">

                    <h3 class="uk-card-title"><span uk-icon="icon:bookmark; ratio:1"></span> Experiences</h3>

                    <div>
                        <span uk-icon="icon:list; ratio:1"></span>
                        <a href="{{ route('admin.experiences.index') }}" class="uk-button uk-button-text">
                            Liste des Experiences
                        </a>

                        <br/>
                        <span uk-icon="icon:plus-circle; ratio:1"></span>
                        <a href="{{ route('admin.experiences.create') }}" class="uk-button uk-button-text">
                            Ajouter une Experience
                        </a>
                    </div>

                    <div class="uk-text-meta uk-float-right">
                        <span>?-</span>
                        <a href="#" class="uk-button uk-button-text" uk-toggle="target: #aide-experience">
                            Aide
                        </a>
                    </div>

                    <!-- Modal to help for Experiences -->
                    <div id="aide-experience" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body">
                            <button class="uk-modal-close-default" type="button" uk-close></button>
                            <h2 class="uk-modal-title">Experiences</h2>

                            <p>A propos de &#171; Experiences &#187;</p>
                            <ul>
                                <li>
                                    Pour enregistrer une nouvelle experience, cliquer sur <strong>&#171; Ajouter une experience &#187;</strong>
                                </li>
                                <li>
                                    Pour voir la liste ou modifier les experiences enregistrées, cliquer sur <strong>&#171; Liste des experiences &#187;</strong>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                <!-- CPanel Technologie -->
                <div class="uk-card uk-card-default uk-card-body uk-flex-auto">

                    <h3 class="uk-card-title"><span uk-icon="icon:500px; ratio:1"></span> Technologies</h3>

                    <div>
                        <span uk-icon="icon:list; ratio:1"></span>
                        <a href="{{ route('admin.technologies.index') }}" class="uk-button uk-button-text">
                            Liste des Technologies
                        </a>

                        <br/>
                        <span uk-icon="icon:plus-circle; ratio:1"></span>
                        <a href="{{ route('admin.technologies.create') }}" class="uk-button uk-button-text">
                            Ajouter une Technologie
                        </a>
                    </div>

                    <div class="uk-text-meta uk-float-right">
                        <span>?-</span>
                        <a href="#" class="uk-button uk-button-text" uk-toggle="target: #aide-technologie">
                            Aide
                        </a>
                    </div>

                    <!-- Modal to help for Technologies -->
                    <div id="aide-technologie" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body">
                            <button class="uk-modal-close-default" type="button" uk-close></button>
                            <h2 class="uk-modal-title">Technologies</h2>

                            <p>A propos de &#171; Technologies &#187;</p>
                            <ul>
                                <li>
                                    Pour enregistrer un nouvelle technologie, cliquer sur <strong>&#171; Ajouter une technologie &#187;</strong>
                                </li>
                                <li>
                                    Pour voir la liste ou modifier les technologies enregistrées, cliquer sur <strong>&#171; Liste des technologies &#187;</strong>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                <!-- CPanel Experience_technologie -->
                <div class="uk-card uk-card-default uk-card-body uk-flex-auto">

                    <h3 class="uk-card-title"><span uk-icon="icon: bolt; ratio:1"></span> Experience technologies</h3>

                    <div>
                        <span uk-icon="icon:list; ratio:1"></span>
                        <a href="{{ route('admin.experience_technologies.index') }}" class="uk-button uk-button-text">
                            Liste des Experience technologies
                        </a>

                        <br/>
                        <span uk-icon="icon:plus-circle; ratio:1"></span>
                        <a href="{{ route('admin.experience_technologies.create') }}" class="uk-button uk-button-text">
                            Ajouter une Experience technologie
                        </a>
                    </div>

                    <div class="uk-text-meta uk-float-right">
                        <span>?-</span>
                        <a href="#" class="uk-button uk-button-text" uk-toggle="target: #aide-experience_technologie">
                            Aide
                        </a>
                    </div>

                    <!-- Modal to help for Experience technologies -->
                    <div id="aide-experience_technologie" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body">
                            <button class="uk-modal-close-default" type="button" uk-close></button>
                            <h2 class="uk-modal-title">Experience technologies</h2>

                            <p>A propos de &#171; Experience technologies &#187;</p>
                            <ul>
                                <li>
                                    Pour enregistrer une nouvelle experience technologie, cliquer sur <strong>&#171; Ajouter une experience technologie &#187;</strong>
                                </li>
                                <li>
                                    Pour voir la liste ou modifier les experience technologies enregistrées, cliquer sur <strong>&#171; Liste des experience technologies &#187;</strong>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                <!-- CPanel Skill -->
                <div class="uk-card uk-card-default uk-card-body uk-flex-auto">

                    <h3 class="uk-card-title"><span uk-icon="icon:folder; ratio:1"></span> Skills</h3>

                    <div>
                        <span uk-icon="icon:list; ratio:1"></span>
                        <a href="{{ route('admin.skills.index') }}" class="uk-button uk-button-text">
                            Liste des Skills
                        </a>

                        <br/>
                        <span uk-icon="icon:plus-circle; ratio:1"></span>
                        <a href="{{ route('admin.skills.create') }}" class="uk-button uk-button-text">
                            Ajouter un Skill
                        </a>
                    </div>

                    <div class="uk-text-meta uk-float-right">
                        <span>?-</span>
                        <a href="#" class="uk-button uk-button-text" uk-toggle="target: #aide-skill">
                            Aide
                        </a>
                    </div>

                    <!-- Modal to help for Skills -->
                    <div id="aide-skill" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body">
                            <button class="uk-modal-close-default" type="button" uk-close></button>
                            <h2 class="uk-modal-title">Skills</h2>

                            <p>A propos de &#171; Skills &#187;</p>
                            <ul>
                                <li>
                                    Pour enregistrer un nouveau skill, cliquer sur <strong>&#171; Ajouter un skill &#187;</strong>
                                </li>
                                <li>
                                    Pour voir la liste ou modifier les skills enregistrés, cliquer sur <strong>&#171; Liste des skills &#187;</strong>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                <!-- CPanel Module -->
                <div class="uk-card uk-card-default uk-card-body uk-flex-auto">

                    <h3 class="uk-card-title"><span uk-icon="icon:social; ratio:1"></span> Modules</h3>

                    <div>
                        <span uk-icon="icon:list; ratio:1"></span>
                        <a href="{{ route('admin.modules.index') }}" class="uk-button uk-button-text">
                            Liste des Modules
                        </a>

                        <br/>
                        <span uk-icon="icon:plus-circle; ratio:1"></span>
                        <a href="{{ route('admin.modules.create') }}" class="uk-button uk-button-text">
                            Ajouter un Module
                        </a>
                    </div>

                    <div class="uk-text-meta uk-float-right">
                        <span>?-</span>
                        <a href="#" class="uk-button uk-button-text" uk-toggle="target: #aide-module">
                            Aide
                        </a>
                    </div>

                    <!-- Modal to help for Modules -->
                    <div id="aide-module" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body">
                            <button class="uk-modal-close-default" type="button" uk-close></button>
                            <h2 class="uk-modal-title">Modules</h2>

                            <p>A propos de &#171; Modules &#187;</p>
                            <ul>
                                <li>
                                    Pour enregistrer un nouveau module, cliquer sur <strong>&#171; Ajouter un module &#187;</strong>
                                </li>
                                <li>
                                    Pour voir la liste ou modifier les modules enregistrés, cliquer sur <strong>&#171; Liste des modules &#187;</strong>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                <!-- CPanel Module_skill -->
                <div class="uk-card uk-card-default uk-card-body uk-flex-auto">

                    <h3 class="uk-card-title"><span uk-icon="icon:code; ratio:1"></span> Module skills</h3>

                    <div>
                        <span uk-icon="icon:list; ratio:1"></span>
                        <a href="{{ route('admin.module_skills.index') }}" class="uk-button uk-button-text">
                            Liste des Module skills
                        </a>

                        <br/>
                        <span uk-icon="icon:plus-circle; ratio:1"></span>
                        <a href="{{ route('admin.module_skills.create') }}" class="uk-button uk-button-text">
                            Ajouter un Module skill
                        </a>
                    </div>

                    <div class="uk-text-meta uk-float-right">
                        <span>?-</span>
                        <a href="#" class="uk-button uk-button-text" uk-toggle="target: #aide-module_skill">
                            Aide
                        </a>
                    </div>

                    <!-- Modal to help for Module skills -->
                    <div id="aide-module_skill" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body">
                            <button class="uk-modal-close-default" type="button" uk-close></button>
                            <h2 class="uk-modal-title">Module skills</h2>

                            <p>A propos de &#171; Module skills &#187;</p>
                            <ul>
                                <li>
                                    Pour enregistrer un nouveau module skill, cliquer sur <strong>&#171; Ajouter un module skill &#187;</strong>
                                </li>
                                <li>
                                    Pour voir la liste ou modifier les module skills enregistrés, cliquer sur <strong>&#171; Liste des module skills &#187;</strong>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                <!-- CPanel Work -->
                <div class="uk-card uk-card-default uk-card-body uk-flex-auto">

                    <h3 class="uk-card-title"><span uk-icon="icon:database; ratio:1"></span> Works</h3>

                    <div>
                        <span uk-icon="icon:list; ratio:1"></span>
                        <a href="{{ route('admin.works.index') }}" class="uk-button uk-button-text">
                            Liste des Works
                        </a>

                        <br/>
                        <span uk-icon="icon:plus-circle; ratio:1"></span>
                        <a href="{{ route('admin.works.create') }}" class="uk-button uk-button-text">
                            Ajouter un Work
                        </a>
                    </div>

                    <div class="uk-text-meta uk-float-right">
                        <span>?-</span>
                        <a href="#" class="uk-button uk-button-text" uk-toggle="target: #aide-work">
                            Aide
                        </a>
                    </div>

                    <!-- Modal to help for Works -->
                    <div id="aide-work" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body">
                            <button class="uk-modal-close-default" type="button" uk-close></button>
                            <h2 class="uk-modal-title">Works</h2>

                            <p>A propos de &#171; Works &#187;</p>
                            <ul>
                                <li>
                                    Pour enregistrer un nouveau work, cliquer sur <strong>&#171; Ajouter un work &#187;</strong>
                                </li>
                                <li>
                                    Pour voir la liste ou modifier les works enregistrés, cliquer sur <strong>&#171; Liste des works &#187;</strong>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                <!-- CPanel Illustration -->
                <div class="uk-card uk-card-default uk-card-body uk-flex-auto">

                    <h3 class="uk-card-title"><span uk-icon="icon:nut; ratio:1"></span> Illustrations</h3>

                    <div>
                        <span uk-icon="icon:list; ratio:1"></span>
                        <a href="{{ route('admin.illustrations.index') }}" class="uk-button uk-button-text">
                            Liste des Illustrations
                        </a>

                        <br/>
                        <span uk-icon="icon:plus-circle; ratio:1"></span>
                        <a href="{{ route('admin.illustrations.create') }}" class="uk-button uk-button-text">
                            Ajouter une Illustration
                        </a>
                    </div>

                    <div class="uk-text-meta uk-float-right">
                        <span>?-</span>
                        <a href="#" class="uk-button uk-button-text" uk-toggle="target: #aide-illustration">
                            Aide
                        </a>
                    </div>

                    <!-- Modal to help for Illustrations -->
                    <div id="aide-illustration" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body">
                            <button class="uk-modal-close-default" type="button" uk-close></button>
                            <h2 class="uk-modal-title">Illustrations</h2>

                            <p>A propos de &#171; Illustrations &#187;</p>
                            <ul>
                                <li>
                                    Pour enregistrer une nouvelle illustration, cliquer sur <strong>&#171; Ajouter une illustration &#187;</strong>
                                </li>
                                <li>
                                    Pour voir la liste ou modifier les illustrations enregistrées, cliquer sur <strong>&#171; Liste des illustrations &#187;</strong>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>


            </div>
        </div>

        <div class="uk-card-footer">
            <a href="javascript:void(0)" class="uk-button uk-button-text">Dernière opération:</a> <small class="uk-text-meta">Listing</small>
        </div>

    </div>

</div>
