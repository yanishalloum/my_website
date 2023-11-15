## Name

Halloum Yanis

## Theme

The project is to implement a cap collections showcase website (eg: baseball cap, NBA cap...).

## Nomenclature

[Object] : Cap
[Inventory]: Inventory
[Gallery]: Wardrobe
[Member]: Member
[User]: User
[Paste]: Paste

## Roles and authentification 

  **"ROLE_USER"**: Can consult public wardrobes, can create/edit/delete his/her inventories and wardrobes.
  **"ROLE_ADMIN"**: Can access localhost:XXXX/admin, can see and manage list of members, can see both public and private wardrobes.

  **How to authentify**:
  Click on login on the bootstrap menu, then enter email and password:
  (First, make sure to use this command: 
  "symfony console doctrine:fixtures:load")
        email/password: role
      - reda@localhost/reda: user
      - sarah@localhost/sarah: user 
      - chris@localhost/chris: admin

## Additional information

2-part menu: User part to access user's inventories, wardrobes and to see other users' public wardrobes.
             Admin part (only shown when connected user is admin) to access to member management.

## Issues Encountered

- Issue when accessing the "Edit Cap" section: 
  "Symfony 5 Error: Object of class Proxies\__CG__\App\Entity\Inventory could not be converted to string": **RESOLVED** by adding __toString method to Inventory.php.
  
- Issue regarding fixtures: "Override reference": **RESOLVED**


