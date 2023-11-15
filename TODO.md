# MyCaps Project

## TODO List

- Use Twig templates for front-office consultation:
  - Cap consultation: **DONE**
  - List of caps of an inventory consultation: **DONE**
  - Navigation from an inventory to its caps: **DONE**

- Integrate CSS formatting using Bootstrap in Twig templates: **DONE**

- Add wardrobe entity to the data model with M-N link with cap entity: **DONE**

- Add CRUD functions to the front-office for the inventory entity: **DONE**

- Contextualization of cap entity creation depending on the inventory entity: **DONE**

- Add User entity to the data model with User-Member link: **DONE**

- Add authentication features: **DONE**

- Access protection for routes forbidden to unauthenticated users or non-admin users: **DONE**

- CRUD data access limited to owners and admins: **DONE**

- Add image uploading feature for the cap entity: **DONE**

## Issues Encountered

- Issue when accessing the "Edit Cap" section: 
  "Symfony 5 Error: Object of class Proxies\__CG__\App\Entity\Inventory could not be converted to string": **RESOLVED** by adding __toString method to Inventory.php.
  
- Issue regarding fixtures: "Override reference": **RESOLVED**
