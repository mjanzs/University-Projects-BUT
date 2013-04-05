<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!-- saved from url=(0067)https://www.fit.vutbr.cz/study/courses/IIS/private/projekt/doc.html -->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

        <title>Projekt IIS</title>
        <style type="text/css">
            table { border-collapse: collapse; }
            td, th { border: 1px solid black; padding: 0.3em 0.5em; text-align: left; }
            dt { font-weight: bold; margin-top: 0.5em; }
        </style>
    </head>
    <body>

        <!-- Zkontrolujte prosím nastavení kódování v hlavičce dokumentu 
             podle použitého editoru -->

        <h1>Videopůjčovna</h1> <!-- Nahradte názvem svého zadání -->

        <dl>
            <dt>Autoři</dt>
            <dd>Martin Janyš <!-- Nahraďte skutečným jménem a e-mailem autora a popisem činnosti -->
                <a href="mailto:xjanys00@stud.fit.vutbr.cz">xjanys00@stud.fit.vutbr.cz</a> -
                správa výpůjček a účtenek, přihlašování a přístupová práva, aktivní komponenty jako datepicker a autocomplete
            </dd>
            <dd>Jan Bednařík <!-- Nahraďte skutečným jménem a e-mailem autora a popisem činnosti -->
                <a href="mailto:xbedna45@stud.fit.vutbr.cz">xbedna45@stud.fit.vutbr.cz</a> - 
                databáze, sprava titulů, žánrů, zákazníků, design
            </dd>
            <dt>URL aplikace</dt>
            <dd><a href="http://www.stud.fit.vutbr.cz/~xjanys00/IIS">http://www.stud.fit.vutbr.cz/~xjanys00/IIS</a></dd>
        </dl>

        <h2>Uživatelé systému pro testování</h2>

        <table>
            <tbody>
                <tr>
                    <th>Login</th>
                    <th>Heslo</th>
                    <th>Role</th>
                    <th>Práva</th>
                </tr>
                <tr>
                    <td>admin</td>
                    <td>admin</td>
                    <td>Administrátor (majitel)</td>
                    <td>Přidávaní, mazaní a editace zaměstnanců a mazaní výpůjček (+ práva zaměstnanece)</td>
                </tr>
                <tr>
                    <td>tom</td>
                    <td>tom</td>
                    <td>Zaměstnanec</td>
                    <td>Přidávaní, mazaní a editace zákazníků, medii, titulů, žánrů a <b>výpůjček</b>.<br/>
                        Nahlížení na účtenky (přidávaná účtenky je generovánou automaticky při převzetí).</td>
                </tr>
                <tr>
                    <td>jakub</td>
                    <td>jakub</td>
                    <td>Zákazník</td>
                    <td>Náhlížení na vlastní výpůjčky a účtenky</td>
                </tr>
            </tbody></table>

        <h2>Implementace</h2>
        <h3>Změny v návrhu</h3>

        <p>
            <ol>
                <li>Tabulky byly přejmenovány na anglické ekvivalenty.</li>
                <li>Hodnoty jako počet medii byli zrušeny a ve výstupu byly nahrazeny agregačními funkcemi.</li>
                <li>Všechny primární klíče jsme sloučili do jednoho typu integer a použili pro ně auto_increment</li>
                <li>Tabulky zaměstnanec a zákazník byly rozděleny na: zákazník, zaměstnanec, adresa a uživatel. 
                    Uživatel obsahuje id, už. jméno a heslo. Používá se pro přihlašování.</li>
            </ol>
        </p>

        <h2>PHP skripty</h2>
        <ul>
            <li>Pro názornost jsme vytvořili grafickou reprezentaci této sekce. <a href="#uc">zde</a></li>
        </ul>

        <h2>Instalace</h2>
        <ul>
            <li>
                Požadavky
                <ul>
                    <li>Yii Framework v1.1.12</li>
                    <li>Funkční web <a href="www.csfd.cz">www.csfd.cz</a> (obrázky titulů)</li>
                    <li>PHP Version 5.3.19</li>
                    <li>Databáze mysql</li>
                </ul>
            </li>

            <li>Pro vytvoření databáze použíjte skript protected/data/videopujcovna.sql</li>
            <li>
                Adresář frameworku má být úmístěn o jednu úrověn výše než index.php (../yii)<br/>
                Tedy: 
                <ul>
                    <li>
                        IIS
                        <ul>
                            <li>assets</li>
                            <li>css</li>
                            <li>images</li>
                            <li>protected</li>
                            <li>doc.html</li>
                            <li>index.php</li>
                        </ul>
                    </li>
                    <li>
                        <b>yii</b>
                    </li>
                </ul>
            </li>
            <li>
                Konfigurace databáze se provádí v souboru protected/config/maip.php v položce 'db'
            </li>
        </ul>

        <h2>Známé problémy</h2>
        <p>--</p>

        <hr/>
        <a name="uc"/>
        <h1>Use Case Diagram</h1>

        <p>
            Následující diagram názorněji ukazuje, kde a jak je implementován případ užití.
            Po najetí se zobrazí jména skriptu, kde je implementace dle MVC.
            Po kliknutí se otevře odkaz v novém tabu z <a href="http://www.stud.fit.vutbr.cz/~xjanys00/IIS/">http://www.stud.fit.vutbr.cz/~xjanys00/IIS/</a>.
            V systému se u většiny akcí nalézá více možností, jak je provést, např. pravé postraní menu, odkaz v náhledu a tabulka hodnot.<br/>
            Systém poskytuje i funkcionalitu nad rámec řešení, hlavně v administraci. Přehled všech funkcí je uveden <a href="http://www.stud.fit.vutbr.cz/~xjanys00/IIS/index.php/admin/index">admin/index</a><br/>
            Automatické odhlašování se nalézá v souboru index.php.<br/>
            <i>Pro některé akce je potřeba přihlášení správné role.</i><br/>
        </p>

        <div class="tooltip" id="n0">zaměstnanec</div>
        <div class="tooltip" id="n1">zrušit registraci<br/>zákazníka</div>
        <div class="tooltip" id="n2">registrovat<br/>zákazníka</div>
        <div class="tooltip" id="n3">půjčit medium</div>
        <div class="tooltip" id="n4">vystavit účet</div>
        <div class="tooltip" id="n5">příjmout medium</div>
        <div class="tooltip" id="n6">změnit profil<br/>zákazníka<br/></div>
        <div class="tooltip" id="n7">zobrazit profil<br/>zákazníka</div>
        <div class="tooltip" id="n8">zobrazit údaje<br/>o titulu</div>
        <div class="tooltip" id="n9">zobrazit seznam<br/>titulů</div>
        <div class="tooltip" id="n10">vytvořit titul</div>
        <div class="tooltip" id="n11">změnit údaje<br/>o titulu</div>
        <div class="tooltip" id="n12">smazat titul</div>
        <div class="tooltip" id="n13">zákazník</div>
        <div class="tooltip" id="n14">
            &quot;/customer/update&quot;<br/>
            <ul>
                <li><b>M: </b>/protected/models/Customer.php</li>
                <li><b>V: </b>/protected/views/customer/update.php, /protected/views/customer/_form.php</li>
                <li><b>C: </b>/protected/controllers/CustomerController.php</li>
            </ul>
        </div>
        <div class="tooltip" id="n15">
            &quot;/customer/delete&quot;
            <ul>
                <li><b>M: </b>/protected/models/Customer.php</li>
                <li><b>V: </b></li>
                <li><b>C: </b>/protected/controllers/CustomerController.php</li>
            </ul>
        </div>
        <div class="tooltip" id="n16">
            &quot;/customer/create&quot;
            <ul>
                <li><b>M: </b>/protected/models/Customer.php</li>
                <li><b>V: </b>/protected/views/customer/create.php, /protected/views/customer/_form.php</li>
                <li><b>C: </b>/protected/controllers/CustomerController.php</li>
            </ul>
        </div>
        <div class="tooltip" id="n17">
            &quot;/title/update&quot;
            <ul>
                <li><b>M: </b>/protected/models/Title.php</li>
                <li><b>V: </b>/protected/views/title/update.php, /protected/views/title/_form.php</li>
                <li><b>C: </b>/protected/controllers/TitleController.php</li>
            </ul>
        </div>
        <div class="tooltip" id="n18">
            &quot;/title/create&quot;
            <ul>
                <li><b>M: </b>/protected/models/Title.php</li>
                <li><b>V: </b>/protected/views/title/create.php, /protected/views/title/_form.php</li>
                <li><b>C: </b>/protected/controllers/TitleController.php</li>
            </ul>
        </div>
        <div class="tooltip" id="n19">
            &quot;/borrowing/create&quot;
            <ul>
                <li><b>M: </b>/protected/models/Borrowing.php</li>
                <li><b>V: </b>/protected/views/borrowing/create.php, /protected/views/borrowing/_form.php</li>
                <li><b>C: </b>/protected/controllers/BorrowingController.php</li>
            </ul>
        </div>
        <div class="tooltip" id="n20">
            &quot;/bill/view&quot;
            <ul>
                <li><b>M: </b>/protected/models/Bill.php</li>
                <li><b>V: </b>/protected/views/view.php</li>
                <li><b>C: </b>/protected/controllers/BillController.php</li>
            </ul>
        </div>
        <div class="tooltip" id="n21">
            &quot;/title/delete&quot;
            <ul>
                <li><b>M: </b>/protected/models/Title.php</li>
                <li><b>V: </b>/protected/views/delete.php</li>
                <li><b>C: </b>/protected/controllers/TitleController.php</li>
            </ul>
        </div>
        <div class="tooltip" id="n22">
            &quot;/title/view&quot;
            <ul>
                <li><b>M: </b>/protected/models/Title.php</li>
                <li><b>V: </b>/protected/views/title/view.php</li>
                <li><b>C: </b>/protected/controllers/TitleController.php</li>
            </ul>
        </div>
        <div class="tooltip" id="n23">
            &quot;/title/index&quot;
            <ul>
                <li><b>M: </b>/protected/models/Title.php</li>
                <li><b>V: </b>/protected/views/title/index.php, /protected/views/title/_view.php</li>
                <li><b>C: </b>/protected/controllers/TitleController.php</li>
            </ul>
        </div>
        <div class="tooltip" id="n24">
            &quot;/customer/view&quot;
            <ul>
                <li><b>M: </b>/protected/models/Customer.php</li>
                <li><b>V: </b>/protected/views/customer/view.php</li>
                <li><b>C: </b>/protected/controllers/CustomerController.php</li>
            </ul>
        </div>
        <div class="tooltip" id="n25">
            &quot;/borrowing/admin&quot;
            <ul>
                <li><b>M: </b>/protected/models/Borrowing.php</li>
                <li><b>V: </b>/protected/views/borrowing/admin.php</li>
                <li><b>C: </b>/protected/controllers/BorrowingController.php</li>
            </ul>
        </div>
        <div class="tooltip" id="n26">registrovat se</div>
        <div class="tooltip" id="n27">
            &quot;/site/register&quot;
            <ul>
                <li><b>M: </b>/protected/models/LoginForm.php, /protected/componets/WebUser.php</li>
                <li><b>V: </b>/protected/views/site/register.php</li>
                <li><b>C: </b>/protected/controllers/SiteController.php</li>
            </ul>
        </div>
        <div class="tooltip" id="n28">přihlásit se</div>
        <div class="tooltip" id="n29">
            &quot;/site/login&quot;
            <ul>
                <li><b>M: </b>/protected/models/LoginForm.php, /protected/componets/WebUser.php</li>
                <li><b>V: </b>/protected/views/site/login.php</li>
                <li><b>C: </b>/protected/controllers/SiteController.php</li>
            </ul>
        </div>
        <div class="tooltip" id="n30">Admin</div>
        <div class="tooltip" id="n31">Spravovat<br/>zaměstnance</div>
        <div class="tooltip" id="n32">
            &quot;/employee/admin&quot;
            <ul>
                <li><b>M: </b>/protected/models/Employee.php</li>
                <li><b>V: </b>/protected/views/employee/admin.php</li>
                <li><b>C: </b>/protected/controllers/EmployeeController.php</li>
            </ul>
        </div>

        <!-- onclick="window.open('', '_blank')" -->
        <map name="image1_1">
            <area shape="rect" coords="402,52,519,78" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n32')"
                  onclick="window.open('http://www.stud.fit.vutbr.cz/~xjanys00/IIS/index.php/employee/admin', '_blank')"/>
            <area shape="rect" coords="402,78,519,137" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n31')"/>
            <area shape="rect" coords="254,15,314,115" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n30')"/>
            <area shape="rect" coords="15,705,132,731" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n29')"
                  onclick="window.open('http://www.stud.fit.vutbr.cz/~xjanys00/IIS/index.php/site/login', '_blank');"/>
            <area shape="rect" coords="15,731,132,790" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n28')"/>
            <area shape="rect" coords="402,705,519,731" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n27')"
                  onclick="window.open('http://www.stud.fit.vutbr.cz/~xjanys00/IIS/index.php/site/register', '_blank')"/>
            <area shape="rect" coords="402,731,519,790" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n26')"/>
            <area shape="rect" coords="402,493,519,519" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n25')"
                  onclick="window.open('http://www.stud.fit.vutbr.cz/~xjanys00/IIS/index.php/borrowing/admin', '_blank')"/>
            <area shape="rect" coords="402,588,519,614" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n24')"
                  onclick="window.open('http://www.stud.fit.vutbr.cz/~xjanys00/IIS/index.php/customer/61', '_blank')"/>
            <area shape="rect" coords="214,590,332,616" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n23')"
                  onclick="window.open('http://www.stud.fit.vutbr.cz/~xjanys00/IIS/index.php/title/index', '_blank')"/>
            <area shape="rect" coords="15,590,132,616" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n22')"
                  onclick="window.open('http://www.stud.fit.vutbr.cz/~xjanys00/IIS/index.php/title/5', '_blank')"/>
            <area shape="rect" coords="15,493,132,519" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n21')"
                  onclick="window.open('http://www.stud.fit.vutbr.cz/~xjanys00/IIS/index.php/title/delete/14', '_blank')"/>
            <area shape="rect" coords="402,396,519,422" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n20')"
                  onclick="window.open('http://www.stud.fit.vutbr.cz/~xjanys00/IIS/index.php/bill/1', '_blank')"/>
            <area shape="rect" coords="402,299,519,325" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n19')"
                  onclick="window.open('http://www.stud.fit.vutbr.cz/~xjanys00/IIS/index.php/borrowing/create', '_blank')"/>
            <area shape="rect" coords="15,395,132,421" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n18')"
                  onclick="window.open('http://www.stud.fit.vutbr.cz/~xjanys00/IIS/index.php/title/create', '_blank')"/>
            <area shape="rect" coords="15,299,132,325" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n17')"
                  onclick="window.open('http://www.stud.fit.vutbr.cz/~xjanys00/IIS/index.php/title/update/5', '_blank')"/>
            <area shape="rect" coords="402,203,519,229" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n16')"
                  onclick="window.open('http://www.stud.fit.vutbr.cz/~xjanys00/IIS/index.php/customer/create', '_blank')"/>
            <area shape="rect" coords="225,203,342,229" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n15')"
                  onclick="window.open('http://www.stud.fit.vutbr.cz/~xjanys00/IIS/index.php/customer/admin', '_blank')" />
            <area shape="rect" coords="15,203,132,229" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n14')"
                  onclick="window.open('http://www.stud.fit.vutbr.cz/~xjanys00/IIS/index.php/customer/update/37', '_blank')"/>
            <area shape="rect" coords="243,756,303,856" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n13')"/>
            <area shape="rect" coords="15,519,132,578" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n12')"/>
            <area shape="rect" coords="15,325,132,384" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n11')"/>
            <area shape="rect" coords="15,421,132,480" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n10')"/>
            <area shape="rect" coords="214,616,332,675" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n9')"/>
            <area shape="rect" coords="15,616,132,675" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n8')"/>
            <area shape="rect" coords="402,614,519,673" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n7')"/>
            <area shape="rect" coords="15,229,132,287" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n6')"/>
            <area shape="rect" coords="402,519,519,578" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n5')"/>
            <area shape="rect" coords="402,422,519,481" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n4')"/>
            <area shape="rect" coords="402,325,519,384" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n3')"/>
            <area shape="rect" coords="402,229,519,287" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n2')"/>
            <area shape="rect" coords="225,229,342,287" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n1')"/>
            <area shape="rect" coords="237,401,297,501" alt="" onmouseout="hideTooltip()" onmouseover="showTooltip('n0')"/>
        </map>


        <table class="yimagetable" cellspacing="0" cellpadding="0" border="0">
            <tr>
                <td><img class="yimage" src="usecase.png" usemap="#image1_1" border="0" alt=""/></td>
            </tr>
        </table>

        <style type="text/css">
            .tooltip {
                font-size:10pt;
                background-color:#FFFFCC;
                border:1px solid black;
                padding:2px
            }
        </style>
        <style type="text/css">
            .tooltip {
                position:absolute;
                display:none
            }
        </style>

        <script type="text/javascript">
            tooltip = null;
            document.onmousemove = updateTooltip;
            function updateTooltip(e) {
                try {
                    if (document.all) {
                        if (document.documentElement && document.documentElement.scrollTop) { // Explorer 6 Strict
                            x = document.documentElement.scrollLeft + window.event.x;
                            y = document.documentElement.scrollTop + window.event.y;
                        }
                        else { // all other Explorers
                            x = document.body.scrollLeft + window.event.x;
                            y = document.body.scrollTop + window.event.y;
                        }
                    }
                    else {
                        x = e.pageX;
                        y = e.pageY;
                    }
                    if (tooltip != null) {
                        o = 20;
                        var sx, sy;
                        if (self.pageYOffset) { // all except Explorer
                            sx = self.pageXOffset;
                            sy = self.pageYOffset;
                        }
                        else if (document.documentElement && document.documentElement.scrollTop) { // Explorer 6 Strict
                            sx = document.documentElement.scrollLeft;
                            sy = document.documentElement.scrollTop;
                        }
                        else if (document.body) { // all other Explorers
                            sx = document.body.scrollLeft;
                            sy = document.body.scrollTop;
                        }
                        t = y + o + tooltip.offsetHeight;
                        w = sy + document.body.clientHeight;
                        if (t > w) {
                            y = y - o - tooltip.offsetHeight;
                        }
                        else {
                            y = y + o;
                        }
                        t = x + o + tooltip.offsetWidth;
                        w = sx + document.body.clientWidth;
                        if (t > w) {
                            x = x - o - tooltip.offsetWidth;
                        }
                        else {
                            x = x + o;
                        }
                        if ((tooltip.style.top == '' || tooltip.style.top == 0) && (tooltip.style.left == '' || tooltip.style.left == 0))
                        {
                            tooltip.style.width = tooltip.offsetWidth + 'px';
                            tooltip.style.height = tooltip.offsetHeight + 'px';
                        }
                        tooltip.style.left = x + "px";
                        tooltip.style.top = y + "px";
                    }
                } catch (error) { error = null; }
            }
            function showTooltip(id) {
                try {
                    tooltip = document.getElementById(id);
                    tooltip.style.display = "block";
                } catch (error) { error = null; }
            }
            function hideTooltip() {
                try {
                    tooltip.style.display = "none";
                } catch (error) { error = null; }
            }
        </script>
    </body>
</html>