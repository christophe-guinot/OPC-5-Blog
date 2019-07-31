{% extends 'template.php' %}

{% block page_title %}
<title>Administration</title>
{% endblock %}

{% block content %}
<h2>Administration</h2>
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-item nav-link active" id="nav-user-tab" data-toggle="tab" href="#nav-user" role="tab" aria-controls="nav-user" aria-selected="true">Utilisateurs</a>
        <a class="nav-item nav-link" id="nav-post-tab" data-toggle="tab" href="#nav-post" role="tab" aria-controls="nav-post" aria-selected="false">Articles</a>
        <a class="nav-item nav-link" id="nav-comment-tab" data-toggle="tab" href="#nav-comment" role="tab" aria-controls="nav-comment" aria-selected="false">Commentaires</a>
    </div>
</nav>
<div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-user" role="tabpanel" aria-labelledby="nav-user-tab">
        {% for pendingUser in pendingUsers %}
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{pendingUser.pseudo}}</h5>
                    <p class="card-text">{{pendingUser.email}}</p>
                </div>
                <form class="card-footer" method="post" action="Administration">
                    <button class="btn btn-primary" type="submit" name="idValidateUser" value="{{pendingUser.id}}">Valider</button>
                    <button class="btn btn-primary" type="submit" name="idDeleteUser" value="{{pendingUser.id}}">Supprimer</button>
                </form>
            </div>    
        {% endfor %}
    </div>

    <div class="tab-pane fade" id="nav-post" role="tabpanel" aria-labelledby="nav-post-tab">
        {% for invalidePost in invalidePosts %}
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{invalidePost.title}}</h5>
                    <p class="card-text">{{invalidePost.standfirst}}</p>
                    <p class="card-text">{{invalidePost.contents}}</p>
                    <h6 class="card-subtitle mb-2 text-muted">Ecrit par {{invalidePost.pseudo}}</h6>
                </div>
                <form class="card-footer" method="post" action="Administration">
                    <button class="btn btn-primary" type="submit" name="idValidatePost" value="{{invalidePost.id}}">Valider</button>
                    <button class="btn btn-primary" type="submit" name="idDeletePost" value="{{invalidePost.id}}">Supprimer</button>
                </form>
            </div>
        {% endfor %}
    </div>

    <div class="tab-pane fade" id="nav-comment" role="tabpanel" aria-labelledby="nav-comment-tab">
        {% for invalideComment in invalideComments %}
            <div class="card">
                <div class="card-body">
                    <p class="card-text">{{invalideComment.contents}}</p>
                </div>
                <form class="card-footer" method="post" action="Administration">
                    <button class="btn btn-primary" type="submit" name="idValidateComment" value="{{invalideComment.id}}">Valider</button>
                    <button class="btn btn-primary" type="submit" name="idDeleteComment" value="{{invalideComment.id}}">Supprimer</button>
                </form>
            </div>
        {% endfor %}
    </div>
</div>


{% endblock %}
