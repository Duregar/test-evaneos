**Refactorisation de la classe TemplateManager**

# Processus de refactorisation

## 1. Isolation du TemplateManager
Mon premier réflexe, au vue du code fourni, a été d'isoler l'instanciation du TemplateManager dans une factory dédiée.
De cette manière, j'ai pu injecter ses dépendances depuis cette factory sans avoir recours à un Singleton de gestion du contexte.

## 2. Nettoyage.
Mon deuxième réflexe, fut de nettoyer le code en retirant ce qui n'était pas nécessaire, en imposant la norme PSR2 et en basant le code sur un autoloader.
J'ai également commencé à utilisant phpunit pour vérifier si mes modifications ne cassaitn rien. J'ai alors remarqué que le test unitaire contenait une erreur que j'ai corrigé.

## 3. Virtualisation des données entrantes dans le TemplateManager
Afin de gagner en souplesse, j'ai fait en sorte de réduire la dépendance du TemplateManager avec les objets issus du contexte, afin de faire de ces derniers de simple données optionnelles.
Leur utilisation n'était pas indispensable mais leur présence était pourtant requises via l'utilisation historique de la classe ApplicationContext.

## 4. Nettoyage.
Viennent ensuite quelques commits de nettoyage en plus ainsi que des refactorisations légères.

## 5. Création du concept de Formatter
Afin d'extraire le code de formatage de la classe TemplateManager, j'ai ajouté plusieurs Formatter permettant de gérer, de manière totalement externe au TemplateManager, les différents traitements à appliquer sur le template.

## 6. Injection des dépendances du QuoteFormatter
Là aussi, je suis passé sur un modèle de service créé depuis un container de service.

## 7. Suppression des dernière méthodes statiques
J'ai finalement déplacé les méthodes statiques de la classe Quote dans un service dédié. Ca rend ces méthodes bien plus réutilisables et facilement customisable selon les situations.

# Autres améliorations à envisager

## 1. Utilisation d'un conteneur de service
Au sein d'un framework moderne comme Symfony ou Laravel, le service TemplateManagerFactory pourrait s'appuyer sur un vrai conteneur de service pour générer le TemplateManager final.
Tous les autres services, comme les repositories, devraient alors également y être attachés.

## 2. Abandon de la classe ApplicationContext
Ce type d'objet statique est dangereux. Il vaut mieux voir le context comme un paramètre injecté au début d'un processus donné. On trouve souvebnt ces données dans un objet de type Request contenant quelques infos sur la requête elle-même, mais aussi sur son contexte.

## 3 Abandon du pattern Singleton.
Ce pattern nuit aux tests unitaires et devrait être abandonné.