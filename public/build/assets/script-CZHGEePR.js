const u=document.querySelector(".sidebar-toggle"),c=document.querySelector(".sidebar-overlay"),r=document.querySelector(".sidebar-menu"),l=document.querySelector(".main");window.innerWidth<768&&(l.classList.toggle("active"),c.classList.toggle("hidden"),r.classList.toggle("-translate-x-full"));u.addEventListener("click",function(e){e.preventDefault(),l.classList.toggle("active"),c.classList.toggle("hidden"),r.classList.toggle("-translate-x-full")});c.addEventListener("click",function(e){e.preventDefault(),l.classList.add("active"),c.classList.add("hidden"),r.classList.add("-translate-x-full")});document.querySelectorAll(".sidebar-dropdown-toggle").forEach(function(e){e.addEventListener("click",function(t){t.preventDefault();const o=e.closest(".group");o.classList.contains("selected")?o.classList.remove("selected"):(document.querySelectorAll(".sidebar-dropdown-toggle").forEach(function(n){n.closest(".group").classList.remove("selected")}),o.classList.add("selected"))})});const d={};document.querySelectorAll(".dropdown").forEach(function(e,t){const o="popper-"+t,n=e.querySelector(".dropdown-toggle"),s=e.querySelector(".dropdown-menu");s.dataset.popperId=o,d[o]=Popper.createPopper(n,s,{modifiers:[{name:"offset",options:{offset:[0,8]}},{name:"preventOverflow",options:{padding:24}}],placement:"bottom-end"})});document.addEventListener("click",function(e){const t=e.target.closest(".dropdown-toggle"),o=e.target.closest(".dropdown-menu");if(t){const n=t.closest(".dropdown").querySelector(".dropdown-menu"),s=n.dataset.popperId;n.classList.contains("hidden")?(i(),n.classList.remove("hidden"),f(s)):(n.classList.add("hidden"),p(s))}else o||i()});function i(){document.querySelectorAll(".dropdown-menu").forEach(function(e){e.classList.add("hidden")})}function f(e){d[e].setOptions(function(t){return{...t,modifiers:[...t.modifiers,{name:"eventListeners",enabled:!0}]}}),d[e].update()}function p(e){d[e].setOptions(function(t){return{...t,modifiers:[...t.modifiers,{name:"eventListeners",enabled:!1}]}})}document.querySelectorAll("[data-tab]").forEach(function(e){e.addEventListener("click",function(t){t.preventDefault();const o=e.dataset.tab,n=e.dataset.tabPage,s=document.querySelector('[data-tab-for="'+o+'"][data-page="'+n+'"]');document.querySelectorAll('[data-tab="'+o+'"]').forEach(function(a){a.classList.remove("active")}),document.querySelectorAll('[data-tab-for="'+o+'"]').forEach(function(a){a.classList.add("hidden")}),e.classList.add("active"),s.classList.remove("hidden")})});
