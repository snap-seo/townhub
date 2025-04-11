<header>

<!--
  <<< Author notes: Course header >>>
  Include a 1280×640 image, course title in sentence case, and a concise description in emphasis.
  In your repository settings: enable template repository, add your 1280×640 social image, auto delete head branches.
  Add your open source license, GitHub uses MIT license.
-->

# Town Hub Child Theme

This is a Child Theme we used for a couple of clients. It includes some overrides to fix some bugs with TownHub.

</header>

<!--
 !
-->

## Functions

In the functions.php I have added a snippet of code allowing you to hide subscriptions from the rest of WooCommerce.

Remove the comments /* and */ from the file and enter your the woocommerce product ID of the subscriptions.

**Back up your original functions.php and other overrides before installing**

## WooCommerce Orders

The original orders page from Townhub has many bugs. This allowed any user with any roles to see all the orders on the site regardless of permissions.
This has since been fixed.

I also updated the file to have the wooorders.php page show up in the sidebar on the users main dashboard.



<footer>

<!--
  <<< Author notes: Footer >>>
  Add a link to get support, GitHub status page, code of conduct, license link.
-->

---

Get help: [Post in our discussion board](https://github.com/orgs/skills/discussions/categories/github-pages) &bull; [Review the GitHub status page](https://www.githubstatus.com/)

&copy; 2023 GitHub &bull; [Code of Conduct](https://www.contributor-covenant.org/version/2/1/code_of_conduct/code_of_conduct.md) &bull; [MIT License](https://gh.io/mit)

</footer>
