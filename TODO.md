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

**Custom avatar**  
The way I manage the dedicated cat avatars ( for David Revoy, Valvin, Cmaloney ) is probably too simple and too easy to cheat. It shouldn't be a part of **{themes}/comments.php** at first, and also probably check for the email of the creator.

**Capcha**  
Capcha should be stronger, but still, easy and accessible for humans.

## Community webcomic

**Community webcomics**  
Nartance made a very cute serie called Pepper&Carrot-mini ; this serie needs to be displayed on the Webcomics category. At the end, under a "community webcomic" label. (we have this two keywords in the translation strings). The image files provided by Nartances needs to be stored into **0_sources/0ther** on a new dedicated folder with a **lang** structure. ( This files doesn't need renderfarm as they are not evolving so much as episodes). The author can provide a source ( a zip; with inside the PSD or KRA file ) ; and flat hi-resolution export of the comic with lang prefix (eg. **en_** ; **fr_** . ).

Example:
```
├─  website
      ├─ 0_sources (> webcomic)
             ├─ 0ther
                  ├─ community-webcomics
                            ├─ community-webcomics
                                    ├─ serie-A-title_by_author-name-A
                                    │    ├─ src
                                    │        ├─ ep01-episode-title-here_by_author-nameA.zip
                                    │        ├─ ep02-episode-title-here_by_author-nameA.zip
                                    │        ├─ ep03-episode-title-here_by_author-nameA.zip
                                    │    ├─ fr_ep01-episode-title-here_by_author-nameA.jpg
                                    │    ├─ fr_ep02-episode-title-here_by_author-nameA.jpg
                                    │    ├─ fr_ep03-episode-title-here_by_author-nameA.jpg
                                    │    ├─ en_ep01-episode-title-here_by_author-nameA.jpg
                                    │    ├─ en_ep02-episode-title-here_by_author-nameA.jpg
                                    │    ├─ en_ep03-episode-title-here_by_author-nameA.jpg
                                    ├─ serie-B-title_ep01-episode-title-here_by_author-nameB
```

The website should create a thumbnail for every community-comic added. Then open a page to browse the series (01 / 02 / 03) and **lang** buttons, and at the end of the comic a button to download the source.
