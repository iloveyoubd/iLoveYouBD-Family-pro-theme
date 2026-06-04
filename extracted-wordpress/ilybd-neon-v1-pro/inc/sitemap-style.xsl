<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0" 
                xmlns:html="http://www.w3.org/TR/REC-html40"
                xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
                xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
    <xsl:template match="/">
        <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <title>ILYBD Advanced Cognitive Sitemap Engine</title>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <style type="text/css">
                    body {
                        font-family: 'Space Grotesk', 'Inter', -apple-system, sans-serif;
                        background: #070b13;
                        color: #c9d1d9;
                        margin: 0;
                        padding: 40px 20px;
                        line-height: 1.6;
                    }
                    .container {
                        max-width: 1200px;
                        margin: 0 auto;
                        background: #0d1527;
                        border: 1px solid rgba(0, 240, 255, 0.15);
                        border-radius: 12px;
                        padding: 40px;
                        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
                    }
                    .header {
                        display: flex;
                        align-items: center;
                        justify-content: space-between;
                        border-bottom: 1px solid rgba(0, 240, 255, 0.15);
                        padding-bottom: 30px;
                        margin-bottom: 30px;
                    }
                    h1 {
                        color: #fff;
                        margin: 0;
                        font-size: 28px;
                        font-weight: 700;
                        letter-spacing: -0.5px;
                    }
                    h1 span {
                        color: #00f0ff;
                        font-family: monospace;
                    }
                    .info {
                        color: #8b949e;
                        font-size: 13px;
                    }
                    .badge {
                        background: rgba(0, 240, 255, 0.1);
                        border: 1px solid rgba(0, 240, 255, 0.3);
                        color: #00f0ff;
                        padding: 6px 14px;
                        border-radius: 20px;
                        font-size: 12px;
                        font-weight: 600;
                        letter-spacing: 0.5px;
                        text-transform: uppercase;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                    }
                    th {
                        background: rgba(13, 21, 39, 0.6);
                        border-bottom: 2px solid rgba(0, 240, 255, 0.3);
                        color: #00f0ff;
                        text-align: left;
                        padding: 14px 18px;
                        font-size: 13px;
                        font-weight: 600;
                        text-transform: uppercase;
                        letter-spacing: 0.5px;
                    }
                    tr {
                        border-bottom: 1px solid rgba(255, 255, 255, 0.04);
                        transition: background 0.2s ease;
                    }
                    tr:hover {
                        background: rgba(0, 240, 255, 0.02);
                    }
                    td {
                        padding: 14px 18px;
                        font-size: 14px;
                        color: #c9d1d9;
                    }
                    a {
                        color: #00ff41;
                        text-decoration: none;
                        transition: color 0.2s ease;
                    }
                    a:hover {
                        color: #00f0ff;
                        text-decoration: underline;
                    }
                    .footer {
                        margin-top: 40px;
                        text-align: center;
                        font-size: 11px;
                        color: #586069;
                        border-top: 1px solid rgba(255, 255, 255, 0.04);
                        padding-top: 20px;
                        font-family: monospace;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header">
                        <div>
                            <h1>ILYBD <span>COGNITIVE</span> SITEMAP</h1>
                            <div class="info">
                                Sitemap Level Feed Interface
                            </div>
                        </div>
                        <div>
                            <span class="badge">PRO ACTIVE - 2040</span>
                        </div>
                    </div>

                    <xsl:if test="sitemap:sitemapindex">
                        <p style="color: #8b949e; font-size: 14px; margin-bottom: 20px;">This is the master search engine XML index sitemap file. It indexes all individual sections dynamically to stay top-ranked in SEO indexes.</p>
                        <table>
                            <thead>
                                <tr>
                                    <th>Sitemap URL</th>
                                    <th>Last Modified</th>
                                </tr>
                            </thead>
                            <tbody>
                                <xsl:for-each select="sitemap:sitemapindex/sitemap:sitemap">
                                    <tr>
                                        <td>
                                            <a href="{sitemap:loc}"><xsl:value-of select="sitemap:loc"/></a>
                                        </td>
                                        <td style="color: #8b949e;">
                                            <xsl:value-of select="sitemap:lastmod"/>
                                        </td>
                                    </tr>
                                </xsl:for-each>
                            </tbody>
                        </table>
                    </xsl:if>

                    <xsl:if test="sitemap:urlset">
                        <p style="color: #8b949e; font-size: 14px; margin-bottom: 20px;">This individual segment contains <strong><xsl:value-of select="count(sitemap:urlset/sitemap:url)"/></strong> URLs indexed with images and custom tags.</p>
                        <table>
                            <thead>
                                <tr>
                                    <th>Target Resource Location</th>
                                    <th>Frequency</th>
                                    <th>Priority</th>
                                    <xsl:if test="sitemap:urlset/sitemap:url/sitemap:lastmod">
                                        <th>Last Update</th>
                                    </xsl:if>
                                </tr>
                            </thead>
                            <tbody>
                                <xsl:for-each select="sitemap:urlset/sitemap:url">
                                    <tr>
                                        <td>
                                            <a href="{sitemap:loc}"><xsl:value-of select="sitemap:loc"/></a>
                                        </td>
                                        <td style="text-transform: capitalize; color: #8b949e;">
                                            <xsl:value-of select="sitemap:changefreq"/>
                                        </td>
                                        <td>
                                            <span style="color: #ffb347; font-weight: bold;"><xsl:value-of select="sitemap:priority"/></span>
                                        </td>
                                        <xsl:if test="sitemap:lastmod">
                                            <td style="color: #8b949e;">
                                                <xsl:value-of select="sitemap:lastmod"/>
                                            </td>
                                        </xsl:if>
                                    </tr>
                                </xsl:for-each>
                            </tbody>
                        </table>
                    </xsl:if>

                    <div class="footer">
                        © 2026 ILOVEYOUBD.COM | INTUITIVE ROBOTS INDEX CONTROL | GENERATED BY CYBER INTELLIGENCE
                    </div>
                </div>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
