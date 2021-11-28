<?xml version="1.0" encoding="UTF-8"?>

<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="/">
        <html>
            <title>XML-Карта сайта</title>
            <style>

                body {
                    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
                    color: #444;
                }

                #sitemap__sidebar{
                    list-style: none;
                    display: flex;
                    padding: 0;
                    margin: 0;
                }

                #sitemap__sidebar_separator{
                    margin: 0 1rem;
                }

                #sitemap {
                    max-width: 980px;
                    margin: 0 auto;
                }

                #sitemap__table {
                    width: 100%;
                    border: solid 1px #ccc;
                    border-collapse: collapse;
                }

                #sitemap__table tr td.loc {
                    direction: ltr;
                }

                #sitemap__table tr th {
                    text-align: left;
                }

                #sitemap__table tr td,
                #sitemap__table tr th {
                    padding: 10px;
                }

                #sitemap__table tr:nth-child(odd) td {
                    background-color: #eee;
                }

                a:hover {
                    text-decoration: none;
                }

            </style>
            <body>
               <div id="sitemap">
                   <div>
                       <ul id="sitemap__sidebar">
                           <li>
                               <a href="/">Главная</a>
                           </li>
                           <li id="sitemap__sidebar_separator">
                               |
                           </li>
                           <li>
                               <a href="/cart">Корзина</a>
                           </li>
                       </ul>
                   </div>
                   <div id="sitemap__header">
                       <h1>XML-карта сайта</h1>
                       <p>Эта XML-карта сайта создана для улучшения индексации содержимого сайта в поисковых системах.</p>
                   </div>
                   <div id="sitemap__content">
                       <h3>XML-карта товаров</h3>
                       <p class="text">Число URL в этой XML-карте: <xsl:value-of select="count(urlset/url)" />.</p>
                       <table id="sitemap__table">
                           <thead>
                               <tr>
                                   <th class="loc">URL</th>
                               </tr>
                           </thead>
                           <tbody>
                               <xsl:for-each select="urlset/url">
                               <tr>
                                   <td class="loc">
                                       <a href="{loc}">
                                           <xsl:value-of select="title"/>
                                       </a>
                                   </td>
                               </tr>
                               </xsl:for-each>
                           </tbody>
                       </table>
                   </div>
               </div>
            </body>
        </html>
    </xsl:template>

</xsl:stylesheet>