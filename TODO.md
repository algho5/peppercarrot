List of ideal TODO for the website
==================================

Feel free to pick an item and helps ;-)

## Author page

**Easier and centralized attribution for contributors** 
Improves **CONTRIBUTORS.md** in the repository **peppercarrot/webcomics**.
- Add mini photos/avatar and contact (email/website) of our contributors (needs contact, permission
- Refactor the list of lang with header title and developp a little more "who does what". Old README are still visible [here](https://framagit.org/peppercarrot/webcomics/commit/14947ec1f2c1e53247b49a4e85c449488bf12fd5). (eg. userX lead is actual translation, userY translated ep01/02, userZ corrected episode 6).
- Remove "My carreer in 7 bubbles:" and integrate the "About David Revoy" better to the **CONTRIBUTORS.md** (columns?).

## Sources page

**Split lang dictionnary** (host it in JSON?)  
Split the big dictionnary of Pepper&Carrot ISO langs inside **{themes}/static-sources.php** of ``"ISO => longisoname"`` in static-sources.php: we need an external **peppercarrot-lang-ISO.json** file maybe to manage that. To study: **data/configuration/plugins/plxMyMultiLingue.xml** It's probably the database with all the real lang; where I setup everything for the lang with a GUI in PluXML configuration.

## Comment system

**Admin avatar**  
The way I manage the dedicated cat avatars ( for David Revoy, Valvin, Cmaloney ) is probably too simple and too easy to cheat. It shouldn't be a part of **{themes}/comments.php** at first, and also probably check for the email of the creator.

**Capcha**  
Capcha should be stronger, but still, easy and accessible for humans.
