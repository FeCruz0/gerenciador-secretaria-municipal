import{r as d,a as _,j as e,L as M,d as C}from"./app-b2b9ffa3.js";/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const g=(...a)=>a.filter((t,o,s)=>!!t&&t.trim()!==""&&s.indexOf(t)===o).join(" ").trim();/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const A=a=>a.replace(/([a-z0-9])([A-Z])/g,"$1-$2").toLowerCase();/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const $=a=>a.replace(/^([A-Z])|[\s-_]+(\w)/g,(t,o,s)=>s?s.toUpperCase():o.toLowerCase());/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const y=a=>{const t=$(a);return t.charAt(0).toUpperCase()+t.slice(1)};/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */var p={xmlns:"http://www.w3.org/2000/svg",width:24,height:24,viewBox:"0 0 24 24",fill:"none",stroke:"currentColor",strokeWidth:2,strokeLinecap:"round",strokeLinejoin:"round"};/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const L=a=>{for(const t in a)if(t.startsWith("aria-")||t==="role"||t==="title")return!0;return!1},H=d.createContext({}),S=()=>d.useContext(H),q=d.forwardRef(({color:a,size:t,strokeWidth:o,absoluteStrokeWidth:s,className:c="",children:i,iconNode:u,...h},n)=>{const{size:l=24,strokeWidth:x=2,absoluteStrokeWidth:m=!1,color:f="currentColor",className:N=""}=S()??{},v=s??m?Number(o??x)*24/Number(t??l):o??x;return d.createElement("svg",{ref:n,...p,width:t??l??p.width,height:t??l??p.height,stroke:a??f,strokeWidth:v,className:g("lucide",N,c),...!i&&!L(h)&&{"aria-hidden":"true"},...h},[...u.map(([j,w])=>d.createElement(j,w)),...Array.isArray(i)?i:[i]])});/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const r=(a,t)=>{const o=d.forwardRef(({className:s,...c},i)=>d.createElement(q,{ref:i,iconNode:t,className:g(`lucide-${A(y(a))}`,`lucide-${a}`,s),...c}));return o.displayName=y(a),o};/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const E=[["path",{d:"M10.268 21a2 2 0 0 0 3.464 0",key:"vwvbt9"}],["path",{d:"M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326",key:"11g9vi"}]],W=r("bell",E);/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const z=[["path",{d:"M10 12h4",key:"a56b0p"}],["path",{d:"M10 8h4",key:"1sr2af"}],["path",{d:"M14 21v-3a2 2 0 0 0-4 0v3",key:"1rgiei"}],["path",{d:"M6 10H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-2",key:"secmi2"}],["path",{d:"M6 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16",key:"16ra0t"}]],b=r("building-2",z);/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const U=[["circle",{cx:"12",cy:"12",r:"10",key:"1mglay"}],["path",{d:"M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3",key:"1u773s"}],["path",{d:"M12 17h.01",key:"p32p05"}]],V=r("circle-question-mark",U);/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const I=[["path",{d:"M15 3h6v6",key:"1q9fwt"}],["path",{d:"M10 14 21 3",key:"gplh6r"}],["path",{d:"M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6",key:"a6xqqp"}]],P=r("external-link",I);/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const R=[["path",{d:"M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z",key:"1oefj6"}],["path",{d:"M14 2v5a1 1 0 0 0 1 1h5",key:"wfsgrz"}],["path",{d:"M10 9H8",key:"b1mrlr"}],["path",{d:"M16 13H8",key:"t4e002"}],["path",{d:"M16 17H8",key:"z1uh3a"}]],B=r("file-text",R);/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const F=[["path",{d:"m6 14 1.5-2.9A2 2 0 0 1 9.24 10H20a2 2 0 0 1 1.94 2.5l-1.54 6a2 2 0 0 1-1.95 1.5H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H18a2 2 0 0 1 2 2v2",key:"usdka0"}]],D=r("folder-open",F);/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const G=[["rect",{width:"18",height:"18",x:"3",y:"3",rx:"2",ry:"2",key:"1m3agn"}],["circle",{cx:"9",cy:"9",r:"2",key:"af1f0g"}],["path",{d:"m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21",key:"1xmnt7"}]],k=r("image",G);/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const O=[["rect",{width:"7",height:"9",x:"3",y:"3",rx:"1",key:"10lvy0"}],["rect",{width:"7",height:"5",x:"14",y:"3",rx:"1",key:"16une8"}],["rect",{width:"7",height:"9",x:"14",y:"12",rx:"1",key:"1hutg5"}],["rect",{width:"7",height:"5",x:"3",y:"16",rx:"1",key:"ldoo1y"}]],T=r("layout-dashboard",O);/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const Q=[["path",{d:"m16 17 5-5-5-5",key:"1bji2h"}],["path",{d:"M21 12H9",key:"dn1m92"}],["path",{d:"M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4",key:"1uf3rs"}]],Z=r("log-out",Q);/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const K=[["path",{d:"M4 5h16",key:"1tepv9"}],["path",{d:"M4 12h16",key:"1lakjw"}],["path",{d:"M4 19h16",key:"1djgab"}]],Y=r("menu",K);/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const J=[["path",{d:"M15 18h-5",key:"95g1m2"}],["path",{d:"M18 14h-8",key:"sponae"}],["path",{d:"M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-4 0v-9a2 2 0 0 1 2-2h2",key:"39pd36"}],["rect",{width:"8",height:"4",x:"10",y:"6",rx:"1",key:"aywv1n"}]],X=r("newspaper",J);/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ee=[["path",{d:"M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915",key:"1i5ecw"}],["circle",{cx:"12",cy:"12",r:"3",key:"1v7zrd"}]],te=r("settings",ee);/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ae=[["path",{d:"m16 11 2 2 4-4",key:"9rsbq5"}],["path",{d:"M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2",key:"1yyitq"}],["circle",{cx:"9",cy:"7",r:"4",key:"nufk8"}]],se=r("user-check",ae);/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const re=[["path",{d:"M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2",key:"975kel"}],["circle",{cx:"12",cy:"7",r:"4",key:"17ys0d"}]],oe=r("user",re);/**
 * @license lucide-react v1.21.0 - ISC
 *
 * This source code is licensed under the ISC license.
 * See the LICENSE file in the root directory of this source tree.
 */const ne=[["path",{d:"M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2",key:"1yyitq"}],["path",{d:"M16 3.128a4 4 0 0 1 0 7.744",key:"16gr8j"}],["path",{d:"M22 21v-2a4 4 0 0 0-3-3.87",key:"kshegd"}],["circle",{cx:"9",cy:"7",r:"4",key:"nufk8"}]],ce=r("users",ne);function le({children:a,title:t}){const{auth:o,flash:s}=_().props,c=o==null?void 0:o.user,i=[{label:"Painel",routeName:"dashboard",icon:T},{label:"Relatórios de Gestão",routeName:"relatorio_de_gestao.index",icon:B},{label:"Notícias",routeName:"noticias.index",icon:X},{label:"Pessoas",routeName:"pessoas.index",icon:ce},{label:"Unidades",routeName:"unidades.index",icon:b},{label:"Lideranças",routeName:"liderancas.index",icon:se},{label:"Arquivos",routeName:"arquivos.index",icon:D},{label:"Banners",routeName:"banners.index",icon:k},{label:"FAQ",routeName:"faqs.index",icon:V},{label:"Galeria",routeName:"galeria_imagens.index",icon:k},{label:"Notificações",routeName:"notificacoes.index",icon:W},{label:"Atalhos Web",routeName:"web_atalhos.index",icon:P},{label:"Usuários",routeName:"users.index",icon:te}],u=n=>{try{const l=n.split(".")[0];return route().current(`${l}.*`)||route().current(n)}catch{return!1}},h=n=>{n.preventDefault(),confirm("Tem certeza que deseja sair do sistema?")&&C.Inertia.post(route("logout"))};return e.jsxs("div",{className:"min-h-screen flex bg-slate-950 text-slate-100 font-sans",children:[e.jsxs("aside",{className:"w-64 bg-slate-900 border-r border-slate-800 flex flex-col shrink-0",children:[e.jsxs("div",{className:"h-16 flex items-center px-6 border-b border-slate-800 gap-2",children:[e.jsx(b,{className:"h-6 w-6 text-indigo-500"}),e.jsx("span",{className:"font-bold text-lg text-slate-100 tracking-tight",children:"SEMAS Painel"})]}),e.jsx("nav",{className:"flex-1 overflow-y-auto py-4 px-3 space-y-1",children:i.map((n,l)=>{const x=n.icon,m=u(n.routeName);return e.jsxs(M,{href:route(n.routeName),className:`flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all ${m?"bg-indigo-600/10 text-indigo-400 border-l-4 border-indigo-500 pl-2":"text-slate-400 hover:text-slate-100 hover:bg-slate-800/50"}`,children:[e.jsx(x,{className:"h-4.5 w-4.5 shrink-0"}),e.jsx("span",{children:n.label})]},l)})}),e.jsx("div",{className:"p-4 border-t border-slate-800",children:e.jsxs("button",{onClick:h,className:"w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all border border-transparent hover:border-red-500/20",children:[e.jsx(Z,{className:"h-4.5 w-4.5 shrink-0"}),e.jsx("span",{children:"Sair do Sistema"})]})})]}),e.jsxs("div",{className:"flex-1 flex flex-col overflow-hidden",children:[e.jsxs("header",{className:"h-16 bg-slate-900/80 backdrop-blur border-b border-slate-800 flex items-center justify-between px-8 z-10 shrink-0",children:[e.jsxs("div",{className:"flex items-center gap-4",children:[e.jsx("button",{className:"lg:hidden text-slate-400 hover:text-slate-100",children:e.jsx(Y,{className:"h-6 w-6"})}),e.jsx("h2",{className:"font-semibold text-lg text-slate-200",children:t})]}),c&&e.jsxs("div",{className:"flex items-center gap-3",children:[e.jsxs("div",{className:"text-right hidden sm:block",children:[e.jsx("p",{className:"text-sm font-medium text-slate-200",children:c.name}),e.jsx("p",{className:"text-xs text-slate-500",children:c.occupation})]}),e.jsx("div",{className:"h-9 w-9 rounded-full bg-indigo-600/20 border border-indigo-500/30 flex items-center justify-center text-indigo-400",children:c.profile_photo_path?e.jsx("img",{src:`/storage/${c.profile_photo_path}`,alt:c.name,className:"h-9 w-9 rounded-full object-cover"}):e.jsx(oe,{className:"h-4 w-4"})})]})]}),e.jsxs("main",{className:"flex-1 overflow-y-auto p-8 relative",children:[(s==null?void 0:s.success)&&e.jsx("div",{className:"mb-6 p-4 rounded-lg bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm flex items-center justify-between",children:e.jsx("span",{children:s.success})}),(s==null?void 0:s.error)&&e.jsx("div",{className:"mb-6 p-4 rounded-lg bg-red-500/10 border border-red-500/30 text-red-400 text-sm flex items-center justify-between",children:e.jsx("span",{children:s.error})}),a]}),e.jsxs("footer",{className:"h-12 border-t border-slate-800 bg-slate-900/50 flex items-center justify-between px-8 text-xs text-slate-500 shrink-0",children:[e.jsxs("p",{children:["© ",new Date().getFullYear()," SEMAS. Todos os direitos reservados."]}),e.jsx("p",{className:"hidden md:block",children:"Gerenciador de Secretaria Municipal"})]})]})]})}export{le as A};
