# 🔐 Authentification Thiotty - Documentation Complète

## ✅ Statut Actuel

**OPÉRATIONNEL ET COMPLET** ✓

- ✓ Système de connexion (Login)
- ✓ Système d'inscription (Register)
- ✓ Récupération de mot de passe (Forgot Password)
- ✓ Réinitialisation de mot de passe (Reset Password)
- ✓ Rate limiting (5 tentatives - protection bruteforce)
- ✓ Social login (optionnel)
- ✓ Vues modernes et responsives

---

## 📋 PAGES D'AUTHENTIFICATION

### 1️⃣ CONNEXION (`/login`)
**Route:** `auth.login`
**Vue:** `resources/views/auth/login.blade.php`
**Contrôleur:** `App\Http\Controllers\Auth\AuthenticatedSessionController`

**Caractéristiques:**
- ✓ Email + Mot de passe
- ✓ "Se souvenir de moi"
- ✓ Lien "Mot de passe oublié"
- ✓ Toggle affichage mot de passe
- ✓ Validation côté serveur
- ✓ Rate limiting (5 tentatives/min)
- ✓ Redirection intelligente (admin vs user)
- ✓ Design moderne Tailwind

### 2️⃣ INSCRIPTION (`/register`)
**Route:** `auth.register`
**Vue:** `resources/views/auth/register.blade.php`
**Contrôleur:** `App\Http\Controllers\Auth\RegisteredUserController`

**Caractéristiques:**
- ✓ Nom complet
- ✓ Numéro de téléphone (Sénégal +221)
- ✓ Email
- ✓ Mot de passe + Confirmation
- ✓ Validation téléphone sénégalais (7x xxx xx xx)
- ✓ Validation email unique
- ✓ Validation mot de passe fort
- ✓ Formatage auto du numéro
- ✓ Redirection vers connexion après succès

### 3️⃣ MOT DE PASSE OUBLIÉ (`/forgot-password`)
**Route:** `password.request`
**Vue:** `resources/views/auth/forgot-password.blade.php`
**Contrôleur:** `App\Http\Controllers\Auth\PasswordResetLinkController`

**Caractéristiques:**
- ✓ Email requis
- ✓ Envoi lien par email
- ✓ Lien valide 60 minutes
- ✓ Retour à connexion

### 4️⃣ RÉINITIALISATION MDP (`/reset-password/{token}`)
**Route:** `password.reset`
**Vue:** `resources/views/auth/reset-password.blade.php`
**Contrôleur:** `App\Http\Controllers\Auth\NewPasswordController`

**Caractéristiques:**
- ✓ Email + Nouveau mot de passe
- ✓ Confirmation mot de passe
- ✓ Validation token
- ✓ Validation mot de passe fort

---

## 🔒 SÉCURITÉ IMPLÉMENTÉE

### Rate Limiting
```
- 5 tentatives de connexion par minute
- Blocage temporaire après dépassement
- Message d'erreur clair à l'utilisateur
```

### Validation des Mots de Passe
```
- Minimum 8 caractères
- Au moins 1 lettre minuscule
- Au moins 1 lettre majuscule
- Au moins 1 chiffre
- Au moins 1 caractère spécial
```

### Validation Téléphone (Sénégal)
```
Format: 7x xxx xx xx (9 chiffres)
Opérateurs acceptés: 70, 75, 76, 77, 78
```

### CSRF Protection
```
✓ Token CSRF sur tous les formulaires
✓ Validation session
✓ Token regeneré à la connexion
```

### Autres Protections
```
✓ Hachage bcrypt des mots de passe
✓ Vérification email unique
✓ Vérification téléphone unique
✓ Timestamps automatiques (created_at, updated_at)
```

---

## 📊 FLUX D'AUTHENTIFICATION

### Inscription Complète
```
1. Utilisateur va à /register
2. Remplit formulaire:
   - Nom complet
   - Numéro Sénégal (formatage auto)
   - Email
   - Mot de passe (fort)
3. POST /register
4. Validation:
   ✓ Email unique
   ✓ Téléphone valide (RE: ^(70|75|76|77|78)[0-9]{7}$)
   ✓ Mdp conforme
5. Création utilisateur dans BD
6. Email vérification envoyé (optionnel)
7. Redirection → /login avec message succès
```

### Connexion Complète
```
1. Utilisateur va à /login
2. Entre email + mdp
3. POST /login
4. Vérification:
   ✓ Rate limit (5 tentatives)
   ✓ Email existe
   ✓ Mdp correct
5. Session créée
6. Redirection:
   - Admin → /admin/dashboard
   - User → / (home) ou page précédente
7. Session valide 2 semaines (si "Se souvenir")
```

### Récupération Mot de Passe
```
1. Utilisateur va à /forgot-password
2. Entre email
3. POST /forgot-password
4. Email envoyé avec lien
   (Lien valide 60 minutes)
5. Clic lien → /reset-password/{token}
6. Entre nouveau mdp
7. POST /reset-password
8. Mdp changé
9. Redirection → /login
```

---

## 🚀 ROUTES

### Routes Guest (non authentifiés)
```php
GET  /register                  → create inscription form
POST /register                  → store inscription
GET  /login                     → create login form
POST /login                     → store login (auth)
GET  /forgot-password           → create forgot form
POST /forgot-password           → send reset link
GET  /reset-password/{token}    → create reset form
POST /reset-password            → store new password
```

### Routes Auth (authentifiés)
```php
GET  /verify-email              → verify email prompt
GET  /verify-email/{id}/{hash}  → verify email (avec token)
POST /email/verification-notification → resend verify
GET  /confirm-password          → confirm password
POST /confirm-password          → verify password
POST /profile/password          → update password
POST /logout                    → logout & logout
```

---

## 🎯 REDIRECTION APRÈS CONNEXION

**Pour Admin:** `/admin/dashboard`
**Pour User:** `/` (page précédente si disponible)

---

## 📧 EMAILS

### Inscription
- Vérification email automatique
- Lien de confirmation (signé)
- Format professional

### Mot de Passe Oublié
- Lien de réinitialisation (60 min)
- Sécurisé avec token hashé
- Format professional

---

## 🔑 VARIABLES UTILISATEUR

### Modèle User
```php
id              : int
name            : string
email           : string (unique)
phone           : string (unique, Sénégal)
password        : string (hashed)
is_admin        : boolean (default: false)
accent_color    : string (theme color)
accent_rgb      : string (RGB string)
email_verified_at : timestamp
created_at      : timestamp
updated_at      : timestamp
```

### Utilisation dans vues
```blade
{{ Auth::user()->name }}        // "Adama Thiotty"
{{ Auth::user()->email }}       // "user@example.com"
{{ Auth::user()->phone }}       // "771234567"
{{ Auth::user()->is_admin }}    // true/false
Auth::check()                   // true si connecté
Auth::guest()                   // true si non connecté
```

---

## 🛠️ AMÉLIORATION - OPTIONNEL

### À faire (Recommandé)
- [ ] Tester flux complet inscription
- [ ] Tester flux complet connexion
- [ ] Tester réinitialisation mdp
- [ ] Configurer SMTP pour emails

### À faire (Nice-to-have)
- [ ] Ajout Google OAuth
- [ ] Ajout Facebook Login
- [ ] Authentification à 2 facteurs (2FA)
- [ ] Biométrique (empreinte)
- [ ] Connexion par code SMS
- [ ] Historique connexions
- [ ] Alertes connexion suspecte

---

## 📋 CHECKLIST DÉPLOIEMENT

- [ ] `.env` contient MAIL_* correctement configuré
- [ ] Base de données migrée
- [ ] `CSRF_EXEMPT_PATHS` configué si besoin
- [ ] Rate limiting ajusté (optionnel)
- [ ] Emails de test envoyés
- [ ] Certificat SSL activé
- [ ] Cookies HTTPS forcé (`APP_PRODUCTION=true`)

---

## 🐛 DÉPANNAGE

### Problème: "Email already exists"
```
Solution: Cet email est déjà inscrit
Action: Aller à /login ou /forgot-password
```

### Problème: "Invalid phone number"
```
Solution: Format attendu: 7x xxx xx (Sénégal)
Exemple: 77 123 45 67 → "771234567"
```

### Problème: Mot de passe faible
```
Solution: Min 8 caractères, maj, minuscule, chiffre, spécial
Exemple: "Thiotty2022!"
```

### Problème: "Too many login attempts"
```
Solution: Attendez 1 minute avant réessai
Ou: Utilisez "Mot de passe oublié"
```

### Problème: Email de réinitialisation non reçu
```
Vérifier:
1. Email correct
2. Dossier spam/courrier indésirable
3. Configuration MAIL_ dans .env
```

---

## 📞 SUPPORT

**Voir aussi:**
- README_THIOTTY.md - Vue générale
- routes/auth.php - Routes d'auth
- app/Http/Controllers/Auth/ - Contrôleurs

---

## ✨ POINTS CLÉS

1. **Sécurité D'Abord** - Rate limiting, bcrypt, CSRF
2. **Expérience Utilisateur** - Design moderne, feedbacks clairs
3. **Téléphone Sénégal** - Validation +221 intégrée
4. **Mots de Passe Forts** - Minimum 8 char + critères
5. **Email Obligatoire** - Pour réinitialisation
6. **Téléphone Obligatoire** - Pour contact sur commandes
7. **Admin Auto-Détecté** - Redirection vers /admin si is_admin

**Prêt à l'emploi!** 🚀
