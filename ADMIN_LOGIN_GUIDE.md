🔐 ADMIN THIOTTY - GUIDE D'ACCÈS COMPLET

═══════════════════════════════════════════════════════════════════════════

## 👨‍💼 INFORMATIONS DE CONNEXION ADMIN

### Identifiants Par Défaut

Email:      admin@thiotty.com
Mot de passe: thiotty2026

**IMPORTANT:** Changez ce mot de passe après la première connexion!

───────────────────────────────────────────────────────────────────────────

## 🚀 COMMENT SE CONNECTER

### Étape 1: Accédez à la page de connexion
```
http://localhost:8000/login
```

### Étape 2: Entrez les identifiants
- Email: `admin@thiotty.com`
- Mot de passe: `thiotty2026`

### Étape 3: Cliquez sur "Se Connecter"

### Résultat
→ Redirection automatique vers `/admin/dashboard`

───────────────────────────────────────────────────────────────────────────

## 📊 ACCÈS AU TABLEAUBORD ADMIN

URL: http://localhost:8000/admin

Routes disponibles:
```
GET  /admin                    → Dashboard principal
GET  /admin/products           → Gestion produits
GET  /admin/categories         → Gestion catégories
GET  /admin/users              → Gestion utilisateurs
GET  /admin/orders             → Gestion commandes
GET  /admin/zones              → Gestion zones livraison
GET  /admin/gallery            → Gestion galerie
GET  /admin/contacts           → Messages contact
GET  /admin/alerts             → Gestion alertes
GET  /admin/reviews            → Modération avis
```

───────────────────────────────────────────────────────────────────────────

## 🔧 PAGES ADMIN PRINCIPALES

### 1️⃣ TABLEAU DE BORD (/admin)
- Vue d'ensemble des stats
- Dernières commandes
- Avis récents
- Alertes système

### 2️⃣ PRODUITS (/admin/products)
- Lister tous les produits
- Créer nouveau produit
- Éditer produit
- Supprimer produit
- Modifier prix, stock, images

### 3️⃣ CATÉGORIES (/admin/categories)
- Gérer catégories
- Créer/Éditer/Supprimer
- Organisation hiérarchique

### 4️⃣ COMMANDES (/admin/orders)
- Voir toutes les commandes
- Modifier statut
- Voir détails
- Imprimer facture
- Assigner livreur

### 5️⃣ UTILISATEURS (/admin/users)
- Lister utilisateurs
- Attribuer rôle admin
- Révoquer rôle admin
- Vue détails

### 6️⃣ ZONES DE LIVRAISON (/admin/zones)
- Gérer zones de livraison
- Définir frais par zone
- Zones actives/inactives

### 7️⃣ GALERIE (/admin/gallery)
- Gérer images galerie
- Créer diaporama
- Titres et descriptions

### 8️⃣ MESSAGES (/admin/contacts)
- Voir messages de contact
- Filtrer par statut
- Répondre directement
- Archiver messages

### 9️⃣ ALERTES (/admin/alerts)
- Créer alertes promotionnelles
- Envoyer notifications
- Planifier alertes
- Suivi engagement

### 🔟 AVIS (/admin/reviews)
- Modérer avis
- Approuver/Rejeter
- Voir avis non approuvés

───────────────────────────────────────────────────────────────────────────

## 🛡️ CONTRÔLES D'ACCÈS

### Seuls les ADMINS peuvent:
✓ Accéder à `/admin/*`
✓ Modifier produits
✓ Voir toutes les commandes
✓ Gérer utilisateurs
✓ Envoyer alertes
✓ Modérer avis
✓ Voir paiements
✓ Générer rapports

### Utilisateurs normaux:
✗ Pas d'accès admin
✓ Peuvent voir leurs commandes
✓ Peuvent écrire avis
✓ Peuvent voir paiements perso

───────────────────────────────────────────────────────────────────────────

## 📧 NOTIFICATIONS ADMIN

### Automatiques
✓ Email sur nouvelles commandes
✓ Alerte stock bas
✓ Avis négatifs (3 étoiles -)
✓ Messages contact non lus
✓ Paiements échoués

### Config
Configurer dans: `.env` ou Admin Settings

───────────────────────────────────────────────────────────────────────────

## 🔐 SÉCURITÉ ADMIN

### Changez le Mot de Passe!

1. Connectez-vous avec:
   - Email: admin@thiotty.com
   - Mdp: thiotty2026

2. Allez sur `/profile`

3. Cliquez "Changer mot de passe"

4. Entrez nouveau mot de passe fort:
   - Minimum 8 caractères
   - 1 majuscule
   - 1 minuscule
   - 1 chiffre
   - 1 caractère spécial

───────────────────────────────────────────────────────────────────────────

## 📊 STATISTIQUES ADMIN

Voir les statistiques:
- Nombre total commandes
- Revenus (somme total_amount)
- Produits en stock
- Utilisateurs actifs
- Avis par produit
- Paiements par méthode

───────────────────────────────────────────────────────────────────────────

## 🎯 TÂCHES COMMON D'ADMIN

### Exemple 1: Créer un Produit
1. Allez à `/admin/products`
2. Cliquez "Créer produit"
3. Remplissez:
   - Nom
   - Catégorie
   - Description
   - Prix
   - Stock
   - Image
4. Cliquez "Créer"

### Exemple 2: Valider une Commande
1. Allez à `/admin/orders`
2. Cliquez sur commande
3. Changez statut:
   - pending → validated
   - validated → preparing
   - preparing → shipping
   - shipping → delivered
4. Cliquez "Enregistrer"

### Exemple 3: Ajouter Utilisateur Admin
1. Allez à `/admin/users`
2. Sélectionnez utilisateur
3. Cliquez "Attribuer Admin"
4. Confirmer

───────────────────────────────────────────────────────────────────────────

## ⚙️ CONFIGURATION ADMIN

### Fichiers de Configuration
- `config/app.php` - App settings
- `.env` - Variables d'environnement
- `app/Http/Controllers/Admin/*` - Contrôleurs admin

### Variables d'Environnement Admin
```env
ADMIN_EMAIL=admin@thiotty.com
APP_NAME=Thiotty
APP_URL=http://localhost:8000
ADMIN_PHONE=+221783577431
```

───────────────────────────────────────────────────────────────────────────

## 📞 SUPPORT & DÉPANNAGE

### Problème: "Accès refusé"
Vérifier: 
1. Connecté avec compte admin
2. is_admin = true en BD
3. Route protégée correctement

### Problème: "Page introuvable"
Vérifier:
1. routes protégées dans routes/web.php
2. Contrôleurs existent
3. Vues existent

### Problème: Mot de passe oublié
Utiliser: `/forgot-password` pour réinitialiser

───────────────────────────────────────────────────────────────────────────

## 🚀 PREMIER LOGIN - CHECKLIST

Après premier login:
- [ ] Vérifier accès /admin
- [ ] Changer mot de passe (important!)
- [ ] Lire emails de config
- [ ] Vérifier liste produits
- [ ] Vérifier utilisateurs
- [ ] Tester création produit

───────────────────────────────────────────────────────────────────────────

## 📝 NOTES IMPORTANTES

1. **Mot de passe:** Changez-le immédiatement après installation
2. **Backups:** Sauvegardez la BD régulièrement
3. **Logs:** Consultez storage/logs/ pour dépannage
4. **Sécurité:** Utilisez HTTPS en production
5. **Sessions:** Auto-disconnect après inactivité

───────────────────────────────────────────────────────────────────────────

## 🎯 EN RÉSUMÉ

```
ACCÈS ADMIN:
→ http://localhost:8000/login

IDENTIFIANTS:
→ Email: admin@thiotty.com
→ Mdp: thiotty2026

TABLEAU DE BORD:
→ http://localhost:8000/admin

ACTIONS:
→ Gérer produits
→ Voir commandes
→ Gérer utilisateurs
→ Envoyer alertes
→ Modérer avis
```

═══════════════════════════════════════════════════════════════════════════

**Dernière mise à jour:** 12 Avril 2026
**Version:** 1.0.0
**Status:** 🟢 Opérationnel
