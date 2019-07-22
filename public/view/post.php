{% extends 'template.php' %}

{% block page_title %}
<title>{{post.title}} </title>
{% endblock %}

{% block content %}

    <p>{{ post.title }}<br>
    {{ post.standfirst }}<br>
    Dernière modification le {{ post.last_date_change|date("d/m/Y à H:i") }} par  {{ post.pseudo }}
    {% if SESSION.pseudoConnectedUser == post.pseudo %}
    	<a href="Modifier-Article-{{ post.id }}">Modifier</a>
    	<a href="Supprimer-Article-{{ post.id }}">Supprimer</a>
    {% endif %}
    <br>
    {{ post.contents }} 
	</p>

	<br>
	<!--display form if user is registered-->
	{% if SESSION.rankConnectedUser == 'registered' or SESSION.rankConnectedUser == 'admin'%}
		<form method="post" action="ajouter-un-commentaire-{{ post.id }}" >
			<legend> Saisissez votre commentaire </legend>
			<textarea name="contents"></textarea>
			<input type="submit" value="Valider">
		</form>
	{% endif %}
	<br>

	<ul>
	    {% for comment in comments %}
	    	{% if comment.validate == 'yes' %}
	    		<li>
			        <p>{{ comment.pseudo }}<br>
			        {{ comment.contents }}<br>
			        </p>
				</li>
	    	{% else %}
	    		<li>
			        <p>{{ comment.pseudo }}<br>
			        *commentaire en attente de validation*<br>
			        </p>
				</li>
	    	{% endif %}

	    {% endfor %}
	</ul>

	<h2>Pagination</h2>
	<p>
	    {% for page in 1..paging.totalPages %}
	        {% if page == paging.currentPage %}
	            {{page}}
	        {% elseif paging.totalPages == 0 %}
	        {% else %}
	            <a href="Article-{{ post.id }}-Page{{page}}">{{page}}</a>
	        {% endif %}
	    {% endfor %}
	</p>

{% endblock %}