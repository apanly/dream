;
var json_format_ops = {
    style_html:function(html_source, indent_size, indent_character, max_char){
            //Wrapper function to invoke all the necessary constructors and deal with the output.
            var Parser, multi_parser;
            function Parser() {

                this.pos = 0; //Parser position
                this.token = '';
                this.current_mode = 'CONTENT'; //reflects the current Parser mode: TAG/CONTENT
                this.tags = { //An object to hold tags, their position, and their parent-tags, initiated with default values
                    parent: 'parent1',
                    parentcount: 1,
                    parent1: ''
                };
                this.tag_type = '';
                this.token_text = this.last_token = this.last_text = this.token_type = '';


                this.Utils = { //Uilities made available to the various functions
                    whitespace: "\n\r\t ".split(''),
                    single_token: 'br,input,link,meta,!doctype,basefont,base,area,hr,wbr,param,img,isindex,?xml,embed'.split(','), //all the single tags for HTML
                    extra_liners: 'head,body,/html'.split(','), //for tags that need a line of whitespace before them
                    in_array: function (what, arr) {
                        for (var i=0; i<arr.length; i++) {
                            if (what === arr[i]) {
                                return true;
                            }
                        }
                        return false;
                    }
                }

                this.get_content = function () { //function to capture regular content between tags

                    var char = '';
                    var content = [];
                    var space = false; //if a space is needed
                    while (this.input.charAt(this.pos) !== '<') {
                        if (this.pos >= this.input.length) {
                            return content.length?content.join(''):['', 'TK_EOF'];
                        }

                        char = this.input.charAt(this.pos);
                        this.pos++;
                        this.line_char_count++;


                        if (this.Utils.in_array(char, this.Utils.whitespace)) {
                            if (content.length) {
                                space = true;
                            }
                            this.line_char_count--;
                            continue; //don't want to insert unnecessary space
                        }
                        else if (space) {
                            if (this.line_char_count >= this.max_char) { //insert a line when the max_char is reached
                                content.push('\n');
                                for (var i=0; i<this.indent_level; i++) {
                                    content.push(this.indent_string);
                                }
                                this.line_char_count = 0;
                            }
                            else{
                                content.push(' ');
                                this.line_char_count++;
                            }
                            space = false;
                        }
                        content.push(char); //letter at-a-time (or string) inserted to an array
                    }
                    return content.length?content.join(''):'';
                }

                this.get_script = function () { //get the full content of a script to pass to js_beautify

                    var char = '';
                    var content = [];
                    var reg_match = new RegExp('\<\/script' + '\>', 'igm');
                    reg_match.lastIndex = this.pos;
                    var reg_array = reg_match.exec(this.input);
                    var end_script = reg_array?reg_array.index:this.input.length; //absolute end of script
                    while(this.pos < end_script) { //get everything in between the script tags
                        if (this.pos >= this.input.length) {
                            return content.length?content.join(''):['', 'TK_EOF'];
                        }

                        char = this.input.charAt(this.pos);
                        this.pos++;


                        content.push(char);
                    }
                    return content.length?content.join(''):''; //we might not have any content at all
                }

                this.record_tag = function (tag){ //function to record a tag and its parent in this.tags Object
                    if (this.tags[tag + 'count']) { //check for the existence of this tag type
                        this.tags[tag + 'count']++;
                        this.tags[tag + this.tags[tag + 'count']] = this.indent_level; //and record the present indent level
                    }
                    else { //otherwise initialize this tag type
                        this.tags[tag + 'count'] = 1;
                        this.tags[tag + this.tags[tag + 'count']] = this.indent_level; //and record the present indent level
                    }
                    this.tags[tag + this.tags[tag + 'count'] + 'parent'] = this.tags.parent; //set the parent (i.e. in the case of a div this.tags.div1parent)
                    this.tags.parent = tag + this.tags[tag + 'count']; //and make this the current parent (i.e. in the case of a div 'div1')
                }

                this.retrieve_tag = function (tag) { //function to retrieve the opening tag to the corresponding closer
                    if (this.tags[tag + 'count']) { //if the openener is not in the Object we ignore it
                        var temp_parent = this.tags.parent; //check to see if it's a closable tag.
                        while (temp_parent) { //till we reach '' (the initial value);
                            if (tag + this.tags[tag + 'count'] === temp_parent) { //if this is it use it
                                break;
                            }
                            temp_parent = this.tags[temp_parent + 'parent']; //otherwise keep on climbing up the DOM Tree
                        }
                        if (temp_parent) { //if we caught something
                            this.indent_level = this.tags[tag + this.tags[tag + 'count']]; //set the indent_level accordingly
                            this.tags.parent = this.tags[temp_parent + 'parent']; //and set the current parent
                        }
                        delete this.tags[tag + this.tags[tag + 'count'] + 'parent']; //delete the closed tags parent reference...
                        delete this.tags[tag + this.tags[tag + 'count']]; //...and the tag itself
                        if (this.tags[tag + 'count'] == 1) {
                            delete this.tags[tag + 'count'];
                        }
                        else {
                            this.tags[tag + 'count']--;
                        }
                    }
                }

                this.get_tag = function () { //function to get a full tag and parse its type
                    var char = '';
                    var content = [];
                    var space = false;

                    do {
                        if (this.pos >= this.input.length) {
                            return content.length?content.join(''):['', 'TK_EOF'];
                        }

                        char = this.input.charAt(this.pos);
                        this.pos++;
                        this.line_char_count++;

                        if (this.Utils.in_array(char, this.Utils.whitespace)) { //don't want to insert unnecessary space
                            space = true;
                            this.line_char_count--;
                            continue;
                        }

                        if (char === "'" || char === '"') {
                            if (!content[1] || content[1] !== '!') { //if we're in a comment strings don't get treated specially
                                char += this.get_unformatted(char);
                                space = true;
                            }
                        }

                        if (char === '=') { //no space before =
                            space = false;
                        }

                        if (content.length && content[content.length-1] !== '=' && char !== '>'
                            && space) { //no space after = or before >
                            if (this.line_char_count >= this.max_char) {
                                this.print_newline(false, content);
                                this.line_char_count = 0;
                            }
                            else {
                                content.push(' ');
                                this.line_char_count++;
                            }
                            space = false;
                        }
                        content.push(char); //inserts character at-a-time (or string)
                    } while (char !== '>');

                    var tag_complete = content.join('');
                    var tag_index;
                    if (tag_complete.indexOf(' ') != -1) { //if there's whitespace, thats where the tag name ends
                        tag_index = tag_complete.indexOf(' ');
                    }
                    else { //otherwise go with the tag ending
                        tag_index = tag_complete.indexOf('>');
                    }
                    var tag_check = tag_complete.substring(1, tag_index).toLowerCase();
                    if (tag_complete.charAt(tag_complete.length-2) === '/' ||
                        this.Utils.in_array(tag_check, this.Utils.single_token)) { //if this tag name is a single tag type (either in the list or has a closing /)
                        this.tag_type = 'SINGLE';
                    }
                    else if (tag_check === 'script') { //for later script handling
                        this.record_tag(tag_check);
                        this.tag_type = 'SCRIPT';
                    }
                    else if (tag_check === 'style') { //for future style handling (for now it justs uses get_content)
                        this.record_tag(tag_check);
                        this.tag_type = 'STYLE';
                    }
                    else if (tag_check.charAt(0) === '!') { //peek for <!-- comment
                        if (tag_check.indexOf('[if') != -1) { //peek for <!--[if conditional comment
                            if (tag_complete.indexOf('!IE') != -1) { //this type needs a closing --> so...
                                var comment = this.get_unformatted('-->', tag_complete); //...delegate to get_unformatted
                                content.push(comment);
                            }
                            this.tag_type = 'START';
                        }
                        else if (tag_check.indexOf('[endif') != -1) {//peek for <!--[endif end conditional comment
                            this.tag_type = 'END';
                            this.unindent();
                        }
                        else if (tag_check.indexOf('[cdata[') != -1) { //if it's a <[cdata[ comment...
                            var comment = this.get_unformatted(']]>', tag_complete); //...delegate to get_unformatted function
                            content.push(comment);
                            this.tag_type = 'SINGLE'; //<![CDATA[ comments are treated like single tags
                        }
                        else {
                            var comment = this.get_unformatted('-->', tag_complete);
                            content.push(comment);
                            this.tag_type = 'SINGLE';
                        }
                    }
                    else {
                        if (tag_check.charAt(0) === '/') { //this tag is a double tag so check for tag-ending
                            this.retrieve_tag(tag_check.substring(1)); //remove it and all ancestors
                            this.tag_type = 'END';
                        }
                        else { //otherwise it's a start-tag
                            this.record_tag(tag_check); //push it on the tag stack
                            this.tag_type = 'START';
                        }
                        if (this.Utils.in_array(tag_check, this.Utils.extra_liners)) { //check if this double needs an extra line
                            this.print_newline(true, this.output);
                        }
                    }
                    return content.join(''); //returns fully formatted tag
                }

                this.get_unformatted = function (delimiter, orig_tag) { //function to return unformatted content in its entirety

                    if (orig_tag && orig_tag.indexOf(delimiter) != -1) {
                        return '';
                    }
                    var char = '';
                    var content = '';
                    var space = true;
                    do {


                        char = this.input.charAt(this.pos);
                        this.pos++

                        if (this.Utils.in_array(char, this.Utils.whitespace)) {
                            if (!space) {
                                this.line_char_count--;
                                continue;
                            }
                            if (char === '\n' || char === '\r') {
                                content += '\n';
                                for (var i=0; i<this.indent_level; i++) {
                                    content += this.indent_string;
                                }
                                space = false; //...and make sure other indentation is erased
                                this.line_char_count = 0;
                                continue;
                            }
                        }
                        content += char;
                        this.line_char_count++;
                        space = true;


                    } while (content.indexOf(delimiter) == -1);
                    return content;
                }

                this.get_token = function () { //initial handler for token-retrieval
                    var token;

                    if (this.last_token === 'TK_TAG_SCRIPT') { //check if we need to format javascript
                        var temp_token = this.get_script();
                        if (typeof temp_token !== 'string') {
                            return temp_token;
                        }
                        token = js_beautify(temp_token, this.indent_size, this.indent_character, this.indent_level); //call the JS Beautifier
                        return [token, 'TK_CONTENT'];
                    }
                    if (this.current_mode === 'CONTENT') {
                        token = this.get_content();
                        if (typeof token !== 'string') {
                            return token;
                        }
                        else {
                            return [token, 'TK_CONTENT'];
                        }
                    }

                    if(this.current_mode === 'TAG') {
                        token = this.get_tag();
                        if (typeof token !== 'string') {
                            return token;
                        }
                        else {
                            var tag_name_type = 'TK_TAG_' + this.tag_type;
                            return [token, tag_name_type];
                        }
                    }
                }

                this.printer = function (js_source, indent_character, indent_size, max_char) { //handles input/output and some other printing functions

                    this.input = js_source || ''; //gets the input for the Parser
                    this.output = [];
                    this.indent_character = indent_character || ' ';
                    this.indent_string = '';
                    this.indent_size = indent_size || 2;
                    this.indent_level = 0;
                    this.max_char = max_char || 70; //maximum amount of characters per line
                    this.line_char_count = 0; //count to see if max_char was exceeded

                    for (var i=0; i<this.indent_size; i++) {
                        this.indent_string += this.indent_character;
                    }

                    this.print_newline = function (ignore, arr) {
                        this.line_char_count = 0;
                        if (!arr || !arr.length) {
                            return;
                        }
                        if (!ignore) { //we might want the extra line
                            while (this.Utils.in_array(arr[arr.length-1], this.Utils.whitespace)) {
                                arr.pop();
                            }
                        }
                        arr.push('\n');
                        for (var i=0; i<this.indent_level; i++) {
                            arr.push(this.indent_string);
                        }
                    }


                    this.print_token = function (text) {
                        this.output.push(text);
                    }

                    this.indent = function () {
                        this.indent_level++;
                    }

                    this.unindent = function () {
                        if (this.indent_level > 0) {
                            this.indent_level--;
                        }
                    }
                }
                return this;
            }

            /*_____________________--------------------_____________________*/

            multi_parser = new Parser(); //wrapping functions Parser
            multi_parser.printer(html_source, indent_character, indent_size); //initialize starting values



            while (true) {
                var t = multi_parser.get_token();
                multi_parser.token_text = t[0];
                multi_parser.token_type = t[1];

                if (multi_parser.token_type === 'TK_EOF') {
                    break;
                }


                switch (multi_parser.token_type) {
                    case 'TK_TAG_START': case 'TK_TAG_SCRIPT': case 'TK_TAG_STYLE':
                    multi_parser.print_newline(false, multi_parser.output);
                    multi_parser.print_token(multi_parser.token_text);
                    multi_parser.indent();
                    multi_parser.current_mode = 'CONTENT';
                    break;
                    case 'TK_TAG_END':
                        multi_parser.print_newline(true, multi_parser.output);
                        multi_parser.print_token(multi_parser.token_text);
                        multi_parser.current_mode = 'CONTENT';
                        break;
                    case 'TK_TAG_SINGLE':
                        multi_parser.print_newline(false, multi_parser.output);
                        multi_parser.print_token(multi_parser.token_text);
                        multi_parser.current_mode = 'CONTENT';
                        break;
                    case 'TK_CONTENT':
                        if (multi_parser.token_text !== '') {
                            multi_parser.print_newline(false, multi_parser.output);
                            multi_parser.print_token(multi_parser.token_text);
                        }
                        multi_parser.current_mode = 'TAG';
                        break;
                }
                multi_parser.last_token = multi_parser.token_type;
                multi_parser.last_text = multi_parser.token_text;
            }
            return multi_parser.output.join('');
    },
    js_beautify:function(js_source_text, indent_size, indent_character, indent_level){
        var input, output, token_text, last_type, last_text, last_word, current_mode, modes, indent_string;
        var whitespace, wordchar, punct, parser_pos, line_starters, in_case;
        var prefix, token_type, do_block_just_closed, var_line, var_line_tainted;



        function trim_output()
        {
            while (output.length && (output[output.length - 1] === ' ' || output[output.length - 1] === indent_string)) {
                output.pop();
            }
        }

        function print_newline(ignore_repeated)
        {
            ignore_repeated = typeof ignore_repeated === 'undefined' ? true: ignore_repeated;

            trim_output();

            if (!output.length) {
                return; // no newline on start of file
            }

            if (output[output.length - 1] !== "\n" || !ignore_repeated) {
                output.push("\n");
            }
            for (var i = 0; i < indent_level; i++) {
                output.push(indent_string);
            }
        }



        function print_space()
        {
            var last_output = output.length ? output[output.length - 1] : ' ';
            if (last_output !== ' ' && last_output !== '\n' && last_output !== indent_string) { // prevent occassional duplicate space
                output.push(' ');
            }
        }


        function print_token()
        {
            output.push(token_text);
        }

        function indent()
        {
            indent_level++;
        }


        function unindent()
        {
            if (indent_level) {
                indent_level--;
            }
        }


        function remove_indent()
        {
            if (output.length && output[output.length - 1] === indent_string) {
                output.pop();
            }
        }


        function set_mode(mode)
        {
            modes.push(current_mode);
            current_mode = mode;
        }


        function restore_mode()
        {
            do_block_just_closed = current_mode === 'DO_BLOCK';
            current_mode = modes.pop();
        }


        function in_array(what, arr)
        {
            for (var i = 0; i < arr.length; i++)
            {
                if (arr[i] === what) {
                    return true;
                }
            }
            return false;
        }



        function get_next_token()
        {
            var n_newlines = 0;
            var c = '';

            do {
                if (parser_pos >= input.length) {
                    return ['', 'TK_EOF'];
                }
                c = input.charAt(parser_pos);

                parser_pos += 1;
                if (c === "\n") {
                    n_newlines += 1;
                }
            }
            while (in_array(c, whitespace));

            if (n_newlines > 1) {
                for (var i = 0; i < 2; i++) {
                    print_newline(i === 0);
                }
            }
            var wanted_newline = (n_newlines === 1);


            if (in_array(c, wordchar)) {
                if (parser_pos < input.length) {
                    while (in_array(input.charAt(parser_pos), wordchar)) {
                        c += input.charAt(parser_pos);
                        parser_pos += 1;
                        if (parser_pos === input.length) {
                            break;
                        }
                    }
                }

                // small and surprisingly unugly hack for 1E-10 representation
                if (parser_pos !== input.length && c.match(/^[0-9]+[Ee]$/) && input.charAt(parser_pos) === '-') {
                    parser_pos += 1;

                    var t = get_next_token(parser_pos);
                    c += '-' + t[0];
                    return [c, 'TK_WORD'];
                }

                if (c === 'in') { // hack for 'in' operator
                    return [c, 'TK_OPERATOR'];
                }
                return [c, 'TK_WORD'];
            }

            if (c === '(' || c === '[') {
                return [c, 'TK_START_EXPR'];
            }

            if (c === ')' || c === ']') {
                return [c, 'TK_END_EXPR'];
            }

            if (c === '{') {
                return [c, 'TK_START_BLOCK'];
            }

            if (c === '}') {
                return [c, 'TK_END_BLOCK'];
            }

            if (c === ';') {
                return [c, 'TK_END_COMMAND'];
            }

            if (c === '/') {
                var comment = '';
                // peek for comment /* ... */
                if (input.charAt(parser_pos) === '*') {
                    parser_pos += 1;
                    if (parser_pos < input.length) {
                        while (! (input.charAt(parser_pos) === '*' && input.charAt(parser_pos + 1) && input.charAt(parser_pos + 1) === '/') && parser_pos < input.length) {
                            comment += input.charAt(parser_pos);
                            parser_pos += 1;
                            if (parser_pos >= input.length) {
                                break;
                            }
                        }
                    }
                    parser_pos += 2;
                    return ['/*' + comment + '*/', 'TK_BLOCK_COMMENT'];
                }
                // peek for comment // ...
                if (input.charAt(parser_pos) === '/') {
                    comment = c;
                    while (input.charAt(parser_pos) !== "\x0d" && input.charAt(parser_pos) !== "\x0a") {
                        comment += input.charAt(parser_pos);
                        parser_pos += 1;
                        if (parser_pos >= input.length) {
                            break;
                        }
                    }
                    parser_pos += 1;
                    if (wanted_newline) {
                        print_newline();
                    }
                    return [comment, 'TK_COMMENT'];
                }

            }

            if (c === "'" || // string
                c === '"' || // string
                (c === '/' &&
                ((last_type === 'TK_WORD' && last_text === 'return') || (last_type === 'TK_START_EXPR' || last_type === 'TK_END_BLOCK' || last_type === 'TK_OPERATOR' || last_type === 'TK_EOF' || last_type === 'TK_END_COMMAND')))) { // regexp
                var sep = c;
                var esc = false;
                c = '';

                if (parser_pos < input.length) {

                    while (esc || input.charAt(parser_pos) !== sep) {
                        c += input.charAt(parser_pos);
                        if (!esc) {
                            esc = input.charAt(parser_pos) === '\\';
                        } else {
                            esc = false;
                        }
                        parser_pos += 1;
                        if (parser_pos >= input.length) {
                            break;
                        }
                    }

                }

                parser_pos += 1;
                if (last_type === 'TK_END_COMMAND') {
                    print_newline();
                }
                return [sep + c + sep, 'TK_STRING'];
            }

            if (in_array(c, punct)) {
                while (parser_pos < input.length && in_array(c + input.charAt(parser_pos), punct)) {
                    c += input.charAt(parser_pos);
                    parser_pos += 1;
                    if (parser_pos >= input.length) {
                        break;
                    }
                }
                return [c, 'TK_OPERATOR'];
            }

            return [c, 'TK_UNKNOWN'];
        }


        //----------------------------------

        indent_character = indent_character || ' ';
        indent_size = indent_size || 4;

        indent_string = '';
        while (indent_size--) {
            indent_string += indent_character;
        }

        input = js_source_text;

        last_word = ''; // last 'TK_WORD' passed
        last_type = 'TK_START_EXPR'; // last token type
        last_text = ''; // last token text
        output = [];

        do_block_just_closed = false;
        var_line = false;
        var_line_tainted = false;

        whitespace = "\n\r\t ".split('');
        wordchar = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_$'.split('');
        punct = '+ - * / % & ++ -- = += -= *= /= %= == === != !== > < >= <= >> << >>> >>>= >>= <<= && &= | || ! !! , : ? ^ ^= |='.split(' ');

        // words which should always start on new line.
        line_starters = 'continue,try,throw,return,var,if,switch,case,default,for,while,break,function'.split(',');

        // states showing if we are currently in expression (i.e. "if" case) - 'EXPRESSION', or in usual block (like, procedure), 'BLOCK'.
        // some formatting depends on that.
        current_mode = 'BLOCK';
        modes = [current_mode];

        indent_level = indent_level || 0;
        parser_pos = 0; // parser position
        in_case = false; // flag for parser that case/default has been processed, and next colon needs special attention
        while (true) {
            var t = get_next_token(parser_pos);
            token_text = t[0];
            token_type = t[1];
            if (token_type === 'TK_EOF') {
                break;
            }

            switch (token_type) {

                case 'TK_START_EXPR':
                    var_line = false;
                    set_mode('EXPRESSION');
                    if (last_type === 'TK_END_EXPR' || last_type === 'TK_START_EXPR') {
                        // do nothing on (( and )( and ][ and ]( ..
                    } else if (last_type !== 'TK_WORD' && last_type !== 'TK_OPERATOR') {
                        print_space();
                    } else if (in_array(last_word, line_starters) && last_word !== 'function') {
                        print_space();
                    }
                    print_token();
                    break;

                case 'TK_END_EXPR':
                    print_token();
                    restore_mode();
                    break;

                case 'TK_START_BLOCK':

                    if (last_word === 'do') {
                        set_mode('DO_BLOCK');
                    } else {
                        set_mode('BLOCK');
                    }
                    if (last_type !== 'TK_OPERATOR' && last_type !== 'TK_START_EXPR') {
                        if (last_type === 'TK_START_BLOCK') {
                            print_newline();
                        } else {
                            print_space();
                        }
                    }
                    print_token();
                    indent();
                    break;

                case 'TK_END_BLOCK':
                    if (last_type === 'TK_START_BLOCK') {
                        // nothing
                        trim_output();
                        unindent();
                    } else {
                        unindent();
                        print_newline();
                    }
                    print_token();
                    restore_mode();
                    break;

                case 'TK_WORD':

                    if (do_block_just_closed) {
                        print_space();
                        print_token();
                        print_space();
                        break;
                    }

                    if (token_text === 'case' || token_text === 'default') {
                        if (last_text === ':') {
                            // switch cases following one another
                            remove_indent();
                        } else {
                            // case statement starts in the same line where switch
                            unindent();
                            print_newline();
                            indent();
                        }
                        print_token();
                        in_case = true;
                        break;
                    }


                    prefix = 'NONE';
                    if (last_type === 'TK_END_BLOCK') {
                        if (!in_array(token_text.toLowerCase(), ['else', 'catch', 'finally'])) {
                            prefix = 'NEWLINE';
                        } else {
                            prefix = 'SPACE';
                            print_space();
                        }
                    } else if (last_type === 'TK_END_COMMAND' && (current_mode === 'BLOCK' || current_mode === 'DO_BLOCK')) {
                        prefix = 'NEWLINE';
                    } else if (last_type === 'TK_END_COMMAND' && current_mode === 'EXPRESSION') {
                        prefix = 'SPACE';
                    } else if (last_type === 'TK_WORD') {
                        prefix = 'SPACE';
                    } else if (last_type === 'TK_START_BLOCK') {
                        prefix = 'NEWLINE';
                    } else if (last_type === 'TK_END_EXPR') {
                        print_space();
                        prefix = 'NEWLINE';
                    }

                    if (last_type !== 'TK_END_BLOCK' && in_array(token_text.toLowerCase(), ['else', 'catch', 'finally'])) {
                        print_newline();
                    } else if (in_array(token_text, line_starters) || prefix === 'NEWLINE') {
                        if (last_text === 'else') {
                            // no need to force newline on else break
                            print_space();
                        } else if ((last_type === 'TK_START_EXPR' || last_text === '=') && token_text === 'function') {
                            // no need to force newline on 'function': (function
                            // DONOTHING
                        } else if (last_type === 'TK_WORD' && (last_text === 'return' || last_text === 'throw')) {
                            // no newline between 'return nnn'
                            print_space();
                        } else if (last_type !== 'TK_END_EXPR') {
                            if ((last_type !== 'TK_START_EXPR' || token_text !== 'var') && last_text !== ':') {
                                // no need to force newline on 'var': for (var x = 0...)
                                if (token_text === 'if' && last_type === 'TK_WORD' && last_word === 'else') {
                                    // no newline for } else if {
                                    print_space();
                                } else {
                                    print_newline();
                                }
                            }
                        } else {
                            if (in_array(token_text, line_starters) && last_text !== ')') {
                                print_newline();
                            }
                        }
                    } else if (prefix === 'SPACE') {
                        print_space();
                    }
                    print_token();
                    last_word = token_text;

                    if (token_text === 'var') {
                        var_line = true;
                        var_line_tainted = false;
                    }

                    break;

                case 'TK_END_COMMAND':

                    print_token();
                    var_line = false;
                    break;

                case 'TK_STRING':

                    if (last_type === 'TK_START_BLOCK' || last_type === 'TK_END_BLOCK') {
                        print_newline();
                    } else if (last_type === 'TK_WORD') {
                        print_space();
                    }
                    print_token();
                    break;

                case 'TK_OPERATOR':

                    var start_delim = true;
                    var end_delim = true;
                    if (var_line && token_text !== ',') {
                        var_line_tainted = true;
                        if (token_text === ':') {
                            var_line = false;
                        }
                    }

                    if (token_text === ':' && in_case) {
                        print_token(); // colon really asks for separate treatment
                        print_newline();
                        break;
                    }

                    in_case = false;

                    if (token_text === ',') {
                        if (var_line) {
                            if (var_line_tainted) {
                                print_token();
                                print_newline();
                                var_line_tainted = false;
                            } else {
                                print_token();
                                print_space();
                            }
                        } else if (last_type === 'TK_END_BLOCK') {
                            print_token();
                            print_newline();
                        } else {
                            if (current_mode === 'BLOCK') {
                                print_token();
                                print_newline();
                            } else {
                                // EXPR od DO_BLOCK
                                print_token();
                                print_space();
                            }
                        }
                        break;
                    } else if (token_text === '--' || token_text === '++') { // unary operators special case
                        if (last_text === ';') {
                            // space for (;; ++i)
                            start_delim = true;
                            end_delim = false;
                        } else {
                            start_delim = false;
                            end_delim = false;
                        }
                    } else if (token_text === '!' && last_type === 'TK_START_EXPR') {
                        // special case handling: if (!a)
                        start_delim = false;
                        end_delim = false;
                    } else if (last_type === 'TK_OPERATOR') {
                        start_delim = false;
                        end_delim = false;
                    } else if (last_type === 'TK_END_EXPR') {
                        start_delim = true;
                        end_delim = true;
                    } else if (token_text === '.') {
                        // decimal digits or object.property
                        start_delim = false;
                        end_delim = false;

                    } else if (token_text === ':') {
                        // zz: xx
                        // can't differentiate ternary op, so for now it's a ? b: c; without space before colon
                        if (last_text.match(/^\d+$/)) {
                            // a little help for ternary a ? 1 : 0;
                            start_delim = true;
                        } else {
                            start_delim = false;
                        }
                    }
                    if (start_delim) {
                        print_space();
                    }

                    print_token();

                    if (end_delim) {
                        print_space();
                    }
                    break;

                case 'TK_BLOCK_COMMENT':

                    print_newline();
                    print_token();
                    print_newline();
                    break;

                case 'TK_COMMENT':

                    // print_newline();
                    print_space();
                    print_token();
                    print_newline();
                    break;

                case 'TK_UNKNOWN':
                    print_token();
                    break;
            }

            last_type = token_type;
            last_text = token_text;
        }

        return output.join('');
    }
};