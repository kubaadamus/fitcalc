<!-- TWORZENIE ZAPYTAŃ I WYSYŁANIE XHR -->
<script>
    var resultObject;
    var offset = 0;
    var limit = 5;
    var results_num_rows = 0;
    var pages = 0;
    var searchDiv = document.getElementById("search");
    var currency = '<?php echo ($_SESSION['currency']); ?>';
    $(document).ready(function() {
        User_GetProducts();
        refreshChart();
    });

    function User_GetProducts() {

        var queryObject = new Object();
        queryObject.name = "Obiekt do szukania produktów";
        queryObject.title = document.getElementById("search_product_title").value;
        queryObject.artist = document.getElementById("search_product_artist").value;
        queryObject.genre = document.getElementById("search_product_genre").value;
        queryObject.type = document.getElementById("search_product_type").value;
        queryObject.instrument = document.getElementById("search_product_instrument").value;
        queryObject.offset = offset;
        queryObject.limit = document.getElementById("search_limit").value;
        queryObject.sort_by = document.getElementById("search_sort_by").value;
        SQL = ("action=getProducts" + "&object=" + JSON.stringify(queryObject));
        resultObject = XHR(SQL);
        console.log(resultObject);
        //Pobieranie danych do stronicowania
        pages = Math.max(Math.round((resultObject.sql_no_limit / limit) + 0.5), 1);
        $("#page_number").html("Strona " + parseInt((offset / limit) + 1) + " na " + pages);
        //Tworzenie tabeli z danymi
        createResultsTable(resultObject.products_table);

        //Wyświetl ilość znalezionych wyników
        $(".results_info_paragraph").text("Ilość wyników: "+resultObject.products_table.length + " z "+resultObject.sql_no_limit);
    }

    function changeOffset(direction) {
        if (direction == 'previous' && offset != 0) {
            offset -= parseInt(limit);
            User_GetProducts();
        }
        if (offset < 0) {
            offset = parseInt(0);
        }
        if (direction == 'next' && parseInt((offset / limit) + 1) < pages) {
            offset += parseInt(limit);
            User_GetProducts();

        }
    }

    function clearFilters() {
        document.getElementById("search_product_title").value = "";
        document.getElementById("search_product_artist").value = "";
        document.getElementById("search_product_genre").value = "";
        document.getElementById("search_product_type").value = "";
        document.getElementById("search_product_instrument").value = "";
        User_GetProducts();
    }
    // TA FUNKCJA WYSYŁA GOTOWE ZAPYTANIE DO XHR_SCRIPT.PHP i asynchronicznie otrzymuje odp w formie tablicy
    // Jest to tablica produktów a wewnątrz każdego produktu jest mała tablica z jego wariantami.
    //RYSOWANIE TABELI I WKŁADANIE W NIĄ DANYCH ORAZ ODŚWIEŻANIE
    // Główna funkcja rysująca wyniki. Otrzymuje tablicę wynikó z SearchData (resultsArray) i tworzy osobną tablicę
    // Dla każdego z wyników
    function createResultsTable(resultsArray) {
        // wywal wszystkie wyniki bo są przestarzałe (zaznacz wszystkie .tabeleNody i usuń)
        $(".tableNode").remove();
        //JEŚLI BRAK WYNIKÓW TO ZAREAGUJ I PRZERWIJ FUNKCJĘ.
        if (resultsArray[0].length == 0) {
            console.log("BRAK WYNIKÓW!");
            $("#resultsTable").hide();
            return;
        };
        //================= STWÓRZ WYNIKI OD ZERA =========================//--------------------------
        //Złap się htmlowskiego elementu z klasą search (ten element jest w search.php)
        var searchDiv = document.getElementById("search");
        //Dla każdego z wyników wyszukiwania, czyli dla każdego z rowów resultsArraya (PRODUKTU)
        for (var y = 0; y < resultsArray.length; y++) {
            // Stwórz kompletnie osobną TABELE NA WYNIK
            var tableNode = document.createElement('table');
            //Nadaj jej klasę tableNode dla cssowania i późniejszego usuwania (refreshowania)
            tableNode.setAttribute("class", "tableNode");
            //Podczep ją pod główny element czyli div o klasie search
            searchDiv.appendChild(tableNode);
            //Stwórz wiersz, w którym zostaną umieszczone headery
            var headersRowNode = document.createElement("tr");
            headersRowNode.setAttribute("class", "headersRowNode");
            //Za pomocą tablicy szybciej zdefiniujemy headery
            //Zbuduj inny zestaw headerów dla songów, inny dla styli i inny dla ADP.
            //Zestawem headerów jest wygodna tablica, którą obsłuży funkcja createTableHeaders
            if (resultsArray[y]['product_type'] == 'SONG') {
                var tableHeadersArray = ["product _thumbnail", "product _type", "product _title", "product _artist", "product _genre", "product _demo", "product _add_date", "KOSZYK"];
            } else if (resultsArray[y]['product_type'] == 'ADP') {
                var tableHeadersArray = ["product _thumbnail", "product _type", "product _title", "product _genre", "product _demo", "product _add_date", "KOSZYK"];
            } else if (resultsArray[y]['product_type'] == 'STYLE') {
                var tableHeadersArray = ["product _thumbnail", "product _type", "product _title", "product _title_style", "product _artist", "product _genre", "product _demo", "product _add_date", "KOSZYK"];
            } else if (resultsArray[y]['product_type'] == 'PREPAID') {
                var tableHeadersArray = ["product _thumbnail", "product _type", "product _title", "product _add_date", "KOSZYK"];
            }

            // Wybraną tablicę headerów włóż do funkcji, która je utworzy.
            // reateTableHeaders przyjmuje (rodzica do którego zostanie sparentowany)(tablicę headerów)
            createTableHeaders(headersRowNode, tableHeadersArray);
            tableNode.appendChild(headersRowNode);
            //Stwórz wiersz na dane PRODUKTU. W zależności czy produkt jest songiem, stylem czy adp, masz 
            //inny zestaw danych korelujący z headerami.
            var propertiesRowNode = document.createElement('tr');
            if (resultsArray[y]['product_type'] == 'SONG') {
                createTdNode(resultsArray[y], propertiesRowNode, 'product_thumbnail');
                createTdNode(resultsArray[y], propertiesRowNode, 'product_type');
                createTdNode(resultsArray[y], propertiesRowNode, 'product_title');
                createTdNode(resultsArray[y], propertiesRowNode, 'product_artist');
                createTdNode(resultsArray[y], propertiesRowNode, 'product_genre');
                createTdNode(resultsArray[y], propertiesRowNode, 'product_demo_path');
                createTdNode(resultsArray[y], propertiesRowNode, 'product_add_date');
            } else if (resultsArray[y]['product_type'] == 'STYLE') {
                createTdNode(resultsArray[y], propertiesRowNode, 'product_thumbnail');
                createTdNode(resultsArray[y], propertiesRowNode, 'product_type');
                createTdNode(resultsArray[y], propertiesRowNode, 'product_title');
                createTdNode(resultsArray[y], propertiesRowNode, 'product_title_style'); // W stylu dorzucasz to!
                createTdNode(resultsArray[y], propertiesRowNode, 'product_artist');
                createTdNode(resultsArray[y], propertiesRowNode, 'product_genre');
                createTdNode(resultsArray[y], propertiesRowNode, 'product_demo_path');
                createTdNode(resultsArray[y], propertiesRowNode, 'product_add_date');
            } else if (resultsArray[y]['product_type'] == 'ADP') {
                createTdNode(resultsArray[y], propertiesRowNode, 'product_thumbnail');
                createTdNode(resultsArray[y], propertiesRowNode, 'product_type');
                createTdNode(resultsArray[y], propertiesRowNode, 'product_title');
                createTdNode(resultsArray[y], propertiesRowNode, 'product_genre');
                createTdNode(resultsArray[y], propertiesRowNode, 'product_demo_path');
                createTdNode(resultsArray[y], propertiesRowNode, 'product_add_date');
            } else if (resultsArray[y]['product_type'] == 'PREPAID') {
                createTdNode(resultsArray[y], propertiesRowNode, 'product_thumbnail');
                createTdNode(resultsArray[y], propertiesRowNode, 'product_type');
                createTdNode(resultsArray[y], propertiesRowNode, 'product_title');
                createTdNode(resultsArray[y], propertiesRowNode, 'product_add_date');
            }
            tableNode.appendChild(propertiesRowNode);
            //=== UTWÓRZ TD W KTÓRYM BĘDZIE KOSZYK, CENA I ILOŚĆ PREADDOWANYCH WARIANTÓW
            {
                var total_price = "wybierz format"; // zmienna na sumę (cenę) wszystkich preaddowanych wariantów
                var priceTdNode = document.createElement('td'); // komórka na koszyk, ceny itd
                priceTdNode.setAttribute("class", "priceTdNode");
                // NAPIS "CENA" i miejsce na wartość ceny -> product_price_paragraph (nie widoczny defaultowo)
                product_price_paragraph = document.createElement('p');
                product_price_paragraph.setAttribute("class", "product_price_paragraph");
                product_price_paragraph.appendChild(document.createTextNode(total_price));
                priceTdNode.appendChild(document.createTextNode("CENA"));
                priceTdNode.appendChild(product_price_paragraph);
                priceTdNode.appendChild(document.createElement('br'));
                //INFORMACJA O ILOŚCI PREADDOWANYCH PRODUKTÓW
                product_amount_paragraph = document.createElement('p');
                product_amount_paragraph.setAttribute("class", "product_amount_paragraph");
                product_amount_paragraph.appendChild(document.createTextNode("Dodaj do koszyka"));
                product_amount_paragraph.appendChild(document.createTextNode(""));
                priceTdNode.appendChild(product_amount_paragraph);
                priceTdNode.appendChild(document.createElement('br'));
                //KOSZYK
                var addOrdersButtonNode = document.createElement('button');
                addOrdersButtonNode.setAttribute("class", "addOrdersButtonNode");
                addOrdersButtonNode.setAttribute("value", "Add to chart");
                addOrdersButtonNode.setAttribute("onClick", "addOrders(this);");
                priceTdNode.appendChild(addOrdersButtonNode);
                //Doczep td z ceną i koszykiem do rowa z właściwościami produktu
                propertiesRowNode.appendChild(priceTdNode);
            }
            //===================STWÓRZ ROW NA SELEKTORY WARIANTÓW==================
            {
                // Stwórz wiersz w którym będzie napis FORMAT i td z slektorami typu z wariantami
                var variantsRowNode = document.createElement('tr');
                variantsRowNode.setAttribute("class", "variantsRowNode");
                //Teraz dodaj TD z formatami a wewnątrz nich opcje z wariantami
                var variantsTableDataNode = document.createElement('td');
                variantsTableDataNode.setAttribute("colspan", 9);
                variantsTableDataNode.setAttribute("class", "variantsTableDataNode");
                //Stwórz selektory wariantów. (PARENT, FORMAT z bazy danych, LABEL do wyświetlania, BIEŻĄCY PRODUKT)
                createVariantSelector(variantsTableDataNode, "prepaid", "PREPAID", resultsArray[y]); // Parent node, css i zarówno variant_format z SQL, ROW[y] czyli cały
                createVariantSelector(variantsTableDataNode, "adp", "ADP", resultsArray[y]); // Parent node, css i zarówno variant_format z SQL, ROW[y] czyli cały
                createVariantSelector(variantsTableDataNode, "yamaha_song", "YAMAHA SONG", resultsArray[y]); // Parent node, css i zarówno variant_format z SQL, ROW[y] czyli cały
                createVariantSelector(variantsTableDataNode, "yamaha_style", "YAMAHA STYLE", resultsArray[y]);
                createVariantSelector(variantsTableDataNode, "korg_midi", "KORG SONG", resultsArray[y]); //produkt, z którego funkcja createVariantSelector wybiera sobie
                createVariantSelector(variantsTableDataNode, "korg_style", "KORG STYLE", resultsArray[y]);
                createVariantSelector(variantsTableDataNode, "general_midi", "GENERAL MIDI", resultsArray[y]); //podtabelę z wariantami i z niej tworzy listę selektorów
                createVariantSelector(variantsTableDataNode, "mp3", "MP3", resultsArray[y]);
                createVariantSelector(variantsTableDataNode, "mp3_g", "MP3 + G", resultsArray[y]);
                createVariantSelector(variantsTableDataNode, "nuty", "NUTY", resultsArray[y]);
                variantsRowNode.appendChild(variantsTableDataNode);
            }
            tableNode.appendChild(variantsRowNode);
        }
    }
    // Funkcja tworząca odpowiednie nagłówki dla tabeli produktu (PARENT-tablica, Tablica headerów)
    function createTableHeaders(Parent, tableHeadersArray) {
        //Pobiera tabelkę zdefiniowaną powyżej, w której są nazwy headerów i dla każdego z nich doczepia kolejny header do rowa headerów.
        for (var i = 0; i < tableHeadersArray.length; i++) {
            var tdNode = document.createElement("th");
            tdNode.appendChild(document.createTextNode(tableHeadersArray[i]));
            Parent.appendChild(tdNode);
        }
    }
    // Funkcja zapełnia wiersz z danymi produktu ()
    function createTdNode(currentProduct, propertiesRowNode, product_property) {
        //Funcja tworząca td, czyli komórkę z danymi produktu. Ta komórka potem jest podczepiana pod row z danymi.
        var tdNode = document.createElement("td");
        //Wyjątkowo potraktuj komórki, których product_property to product_thumbnail. Stwórz dla nich img z srcem
        if (product_property == 'product_thumbnail') {
            var imageNode = document.createElement("img");
            imageNode.setAttribute("src", currentProduct[product_property]);
            imageNode.setAttribute("class", "thumbnail");
            tdNode.appendChild(imageNode);
            //Inaczej potraktuj też td z propertką product_demo_path, dla nich stwórz player
        } else if (product_property == 'product_demo_path') {
            var audioNode = document.createElement('audio');
            audioNode.setAttribute("controls", "");
            var sourceNode = document.createElement('source');
            sourceNode.setAttribute("src", currentProduct[product_property]);
            audioNode.appendChild(sourceNode);
            tdNode.appendChild(audioNode);
            //Zrób odstęp przed listą wyboru dema
            tdNode.appendChild(document.createElement('br'));
            tdNode.appendChild(document.createTextNode("Wybierz demo:"));
            tdNode.appendChild(document.createElement('br'));
            //Po playerze wrzuć listę z demami do wyboru!
            demoSelectNode = document.createElement('select');
            demoSelectNode.setAttribute("onchange", "setPlayerToDemoSrc(this);");
            // Dla każdego wariantu tego produktu

            //Stwórz najpierw pustą
            for (var i = 0; i < currentProduct['product_variants_list'].length; i++) {
                if (currentProduct['product_variants_list'][i]['variant_is_demo'] == 1) {
                    if (currentProduct['product_variants_list'][i]['variant_format'] != 'nuty') {
                        demoOptionNode = document.createElement('option');
                        demoOptionNode.setAttribute("demoSRC", currentProduct['product_variants_list'][i]['variant_demo_path']);
                        demoOptionNode.appendChild(document.createTextNode(currentProduct['product_variants_list'][i]['variant_instrument']));
                        demoSelectNode.appendChild(demoOptionNode);
                    }
                }
            }
            tdNode.appendChild(demoSelectNode);
            //Wszystkim innym wrzuć po prostu tekst
        } else {
            var textnode = document.createTextNode(currentProduct[product_property]);
            tdNode.appendChild(textnode);
        }
        //Podczep tak utworzony TD do tworzonego wiersza 
        propertiesRowNode.appendChild(tdNode);
    }
    //Funkcja zmienia płytę playerowi zależnie od wybranej opcji dema
    function setPlayerToDemoSrc(demoOptionNode) {
        var newSRC = $(demoOptionNode).children("option:selected").attr("demoSRC")
        //console.log(newSRC);
        var Player = $(demoOptionNode).parent().find("source").attr("src", newSRC);
        //Reloaduj audio
        $(demoOptionNode).parent().find("audio").load();
    }
    //Funkcja tworzy element SELECT i do niego wrzuca kolejne elementy OPTION
    function createVariantSelector(variantsTableDataNode, variantFormat, variantLabel, resultsArrayRow) {
        var formNode = document.createElement('form'); //mega nadrzędny form
        var multiselectDivNode = document.createElement('div'); // Nadrzędny div
        multiselectDivNode.setAttribute("class", "multiselect");
        formNode.style.display = "inline-flex";
        formNode.appendChild(multiselectDivNode);
        //Select box
        var selectBoxDivNode = document.createElement('div');
        selectBoxDivNode.setAttribute("class", "selectBox");
        selectBoxDivNode.setAttribute("onclick", "showCheckboxes(this);");
        //selectBoxDivNode.setAttribute("expanded", 0);
        multiselectDivNode.appendChild(selectBoxDivNode);
        var selectNode = document.createElement('select');
        var optionNode = document.createElement('option');
        optionNode.appendChild(document.createTextNode(variantLabel));
        selectNode.appendChild(optionNode);
        selectBoxDivNode.appendChild(selectNode);
        var overSelectDivNode = document.createElement('div');
        overSelectDivNode.setAttribute("class", "overSelect");
        selectBoxDivNode.appendChild(overSelectDivNode);
        //Checkboxes
        var seriesNames = ["PSR S SERIES", "TYROS", "GENOS", "PA SERIES"];
        for(var x=0; x<seriesNames.length; x++)
        {
        var checkboxesDiv = document.createElement('div');
        checkboxesDiv.setAttribute("id", "checkboxes");
        var instrumentNameParagraph = document.createElement('p');
        instrumentNameParagraph.appendChild(document.createTextNode(seriesNames[x]));
        checkboxesDiv.appendChild(instrumentNameParagraph);
        //Dla każdego elementu listy wewnętrznej o nazwie product_variants_list, zawierającej wszystkie warianty danego produktu
            for (var i = 0; i < resultsArrayRow['product_variants_list'].length; i++) {
                //Jeśli natrafisz na taki wariant, którego format zgadza się z wymaganym przez nas podczas wywołania funkcji (przeszukaj po prostu product_variants_list)
                if (resultsArrayRow['product_variants_list'][i]['variant_format'] == variantFormat) {
                    if(resultsArrayRow['product_variants_list'][i]['variant_instrument_series'].includes(seriesNames[x]))
                        {
                        var label = document.createElement('label');
                            var input = document.createElement('input');
                            input.setAttribute("type", "checkbox");
                            label.appendChild(input);

                            var optionTextNode = document.createTextNode("" +
                                resultsArrayRow['product_variants_list'][i]['variant_instrument_model'] +
                                " "+
                                resultsArrayRow['product_variants_list'][i]['variant_req'] +
                                " (" + Convert_currency(resultsArrayRow['product_variants_list'][i]['variant_price']) + " <?php echo ($_SESSION['currency']) ?>) ");
                            label.appendChild(optionTextNode);
                            input.setAttribute("onclick", "TogglePreAdded(this)");
                            input.setAttribute("pre_added", 0);
                            input.setAttribute("variant_id", resultsArrayRow['product_variants_list'][i]['variant_id']); // ustaw mu id wariantu jako atrybut
                            input.setAttribute("price", price);
                            
                            checkboxesDiv.appendChild(label);
                            multiselectDivNode.appendChild(checkboxesDiv);
                            variantsTableDataNode.appendChild(formNode);
                        }
                }
            }
        }
        
    }
    //Funkcja która zmienia element z preadded na nie preadded i odwrotnie przy zaznaczaniu/odznaczaniu wariantu 
    function TogglePreAdded(optionElement) {
        optionElement = $(optionElement);
        if (optionElement.attr("pre_added") == 0) {
            optionElement.attr("pre_added", 1);
        } else {
            optionElement.attr("pre_added", 0);
        }
        updatePrice(optionElement);
    }

    function showCheckboxes(checkbox) {
        /*
        var checkbox = $(checkbox).parent().parent().find("#checkboxes");
        if (checkbox.attr("expanded") == 1) {
            checkbox.attr("expanded", 0);
            checkbox.css({
                "display": "none"
            });
        } else {
            checkbox.attr("expanded", 1);
            checkbox.css({
                "display": "block"
            });
        }*/
    }
    //OBSŁUGA RÓŻNYCH RZECZY W WYSZUKIWANIU 
    function updatePrice(selectedOption) {
        //Zaznacz lub odznacz kliknięty wariant
        if (selectedOption.attr('pre_added') == 1) {
            //Daj informacje klientowi że chce coś dodać
            $(".preAddedToChartInfo").text("Zaznaczono do dodania");
            $(".preAddedToChartInfo").show();
            $(".preAddedToChartInfo").fadeOut(1000);
        } else {
            //Daj informacje klientowi że chce coś odznaczyć
            $(".preAddedToChartInfo").text("Odznaczono od dodania");
            $(".preAddedToChartInfo").show();
            $(".preAddedToChartInfo").fadeOut(1000);
        }
        console.log(selectedOption.parent().parent().parent().parent().parent().find('input').length);
        var price = 0 // informacja dla koszyka jaka cena zestawu
        var product_amount = 0; // informacja dla koszyka ile produktów będzie dodane
        selectedOption.parent().parent().parent().parent().parent().find('input').each(function() {
            if ($(this).attr("pre_added") == 1) {
                //JEŚLI ODNAJDZIESZ OPTIONSA Z USTAWIONYM PRE_ADDED NA 1:
                product_amount++;
                //console.log($(this).attr("price")); // "this" is the current element in the loop
                price += parseFloat($(this).attr("price"));
            }
        });
        selectedOption.parent().parent().parent().parent().parent().parent().parent().find(".product_amount_paragraph").text("Dodaj " + product_amount + " do koszyka");
        //Zaktualizuj cenę
        if (product_amount < 2) {
            selectedOption.parent().parent().parent().parent().parent().parent().parent().find(".product_price_paragraph").html("PRODUKTU: " + price.toFixed(2) + " <?php echo ($_SESSION['currency']) ?>");
        } else {
            selectedOption.parent().parent().parent().parent().parent().parent().parent().find(".product_price_paragraph").html("ZESTAWU: " + price.toFixed(2) + " <?php echo ($_SESSION['currency']) ?>");
        }
    }

    function addOrders(_addOrdersButton) { // Skrypt dodający wybrany zestaw produktów do koszyka
        addOrdersButton = $(_addOrdersButton);
        var queryObject = new Object();
        queryObject.name = "Obiekt do dodawania do koszyka";
        queryObject.idArray = [];
        //Weź ten przycisk, przeszukaj jego tabelę w poszukiwaniu zaznaczonych do dodania elementów
        //skompletuj je w tabelę i zrób z nich SQL po czym wyślij go do addOrdersScropta!
        var pre_added_variants_options_list = addOrdersButton.parent().parent().parent().find(("input[pre_added=1]"));
        for (var i = 0; i < pre_added_variants_options_list.length; i++) {
            var id_to_add = $(pre_added_variants_options_list[i]).attr("variant_id");
            queryObject.idArray.push(id_to_add);
        }
        SQL = ("username=<?php echo ($_SESSION['username']) ?>&action=addOrders" + "&object=" + JSON.stringify(queryObject));
        //Do sqla doczep też nazwę użytkownika bo ona nie istnieje w add_scropcie w SESSION!
        resultObject = XHR(SQL);
        if (resultObject.name == "Nie jesteś zalogowany!") {
            console.log("Musisz się zalogować aby dodawać produkty do koszyka");
        } else {
            animateChart();
            refreshChart();
            queryObject.idArray = [];
            console.log(queryObject);
        }
    }

    function refreshChart() { // Skrypt odświeżający zawartość i cenę koszyka na zawołanie
        SQL = ("username=<?php echo ($_SESSION['username']) ?>&action=searchChartRefresh");
        resultObject = XHR(SQL);
        console.log(resultObject);
        $(".chart_amount").text("ilość w koszyku:" + resultObject.chart_amount);

        $(".chart_price").text("wartość koszyka:" + Convert_currency(resultObject.chart_price) + " " + currency);
    }
    //Animowanie przycisku koszyka
    function animateChart() {
        //Pokaż informacje że dodano do koszyka i zrób zeby powoli znikała
        $(".addedToChartInfo").show();
        $(".addedToChartInfo").fadeOut(2000);
        //Porusz koszykiem
        var elem = document.getElementById("chart_button");
        var pos = 0.0;
        var id = setInterval(frame, 5);

        function frame() {
            if (pos >= 10) {
                clearInterval(id);
                elem.style.transform = "rotate(0deg)";
            } else {
                pos += 0.1;
                elem.style.transform = "rotate(" + Math.sin(pos) * 10 + "deg)";
            }
        }
    }
</script>