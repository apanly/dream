<?php
use awephp\components\StaticService;
StaticService::includeAppCssStatic( "/css/docs.css",\awephp\assets\AppAsset::className() );
StaticService::includeAppJsStatic( "/js/docs.js",\awephp\assets\AppAsset::className() );
?>
<div class="container-fluid docs">
    <div class="row-fluid">
        <div class="col-md-3 sidebar_wrap">
            <div class="well sidebar-nav">
                <ul class="nav nav-list">
                    <li class="nav-header"><i class="icon-document-alt-stroke"></i><span>中文文档</span></li>
                    <li><a href="/getting-started" class="active">快速入门</a></li>
                    <li><a href="/configuring-tasks" class="false">配置任务</a></li>
                    <li><a href="/sample-gruntfile" class="false">Gruntfile 实例</a></li>
                    <li><a href="/creating-tasks" class="false">创建任务</a></li>
                    <li><a href="/creating-plugins" class="false">创建插件</a></li>
                    <li><a href="/using-the-cli" class="false">使用命令行工具</a></li>
                </ul>
                <ul class="nav nav-list">
                    <li class="nav-header"><span>进阶知识</span></li>
                    <li><a href="/api" class="false">API</a></li>
                    <li><a href="/installing-grunt" class="false">安装 Grunt</a></li>
                    <li><a href="/frequently-asked-questions" class="false">常见问题</a></li>
                    <li><a href="/project-scaffolding" class="false">项目脚手架</a></li>
                </ul>
                <ul class="nav nav-list">
                    <li class="nav-header"><span>社区</span></li>
                    <li><a href="/help-resources" class="false">有用的资源</a></li>
                    <li><a href="/who-uses-grunt" class="false">Grunt 用户列表</a></li>
                    <li><a href="/built-with-grunt-badge" class="false">Grunt 徽章</a></li>
                    <li><a href="/contributing" class="false">贡献</a></li>
                    <li><a href="/development-team" class="false">研发团队</a></li>
                </ul>
                <ul class="nav nav-list">
                    <li class="nav-header"><span>升级指南</span></li>
                    <li><a href="/upgrading-from-0.3-to-0.4" class="false">从 0.3 升级到 0.4 版本</a></li>
                </ul><!--include blocks/advertisements--></div>
        </div>
        <div class="col-md-9 page">
            <div class="hero-unit"><h1>快速入门</h1>
                <p>Grunt和 Grunt 插件是通过 <a href="https://npmjs.org/">npm</a> 安装并管理的，npm是 <a href="http://nodejs.org/">Node.js</a>
                    的包管理器。</p>
                <p><em>Grunt 0.4.x 必须配合Node.js <code>&gt;= 0.8.0</code>版本使用。；奇数版本号的 Node.js 被认为是不稳定的开发版。</em></p>
                <p>在安装 Grunt 前，请确保当前环境中所安装的 <a href="https://npmjs.org/">npm</a> 已经是最新版本，执行 <code>npm update -g
                        npm</code> 指令进行升级（在某些系统中可能需要 <code>sudo</code> 指令）。</p>
                <p>如果你已经安装了 Grunt，现在需要参考一些文档手册，那就请看一看 <a href="/sample-gruntfile"><code>Gruntfile</code> 实例</a> 和如何 <a
                            href="/configuring-tasks">配置任务</a>吧。</p>
                <h2><a class="anchor" href="#cli" name="cli">安装 CLI</a></h2>
                <p><strong> 还在使用 Grunt 0.3 版本吗？请查看 <a href="/upgrading-from-0.3-to-0.4#grunt-0.3-notes">Grunt 0.3
                            注意事项</a> </strong></p>
                <p>在继续学习前，你需要先将Grunt命令行（CLI）安装到全局环境中。安装时可能需要使用sudo（针对OSX、*nix、BSD等系统中）权限或者作为管理员（对于Windows环境）来执行以下命令。</p>
                <pre><code class="lang-shell">npm install -g grunt-cli</code></pre>
                <p>上述命令执行完后，<code>grunt</code> 命令就被加入到你的系统路径中了，以后就可以在任何目录下执行此命令了。</p>
                <p>注意，安装<code>grunt-cli</code>并不等于安装了 Grunt！Grunt CLI的任务很简单：调用与<code>Gruntfile</code>在同一目录中
                    Grunt。这样带来的好处是，允许你在同一个系统上同时安装多个版本的 Grunt。</p>
                <p>这样就能让多个版本的 Grunt 同时安装在同一台机器上。</p>
                <h2><a class="anchor" href="#cli" name="cli">CLI 是如何工作的</a></h2>
                <p>每次运行<code>grunt</code> 时，他就利用node提供的<code>require()</code>系统查找本地安装的
                    Grunt。正是由于这一机制，你可以在项目的任意子目录中运行<code>grunt</code> 。</p>
                <p>如果找到一份本地安装的 Grunt，CLI就将其加载，并传递<code>Gruntfile</code>中的配置信息，然后执行你所指定的任务。为了更好的理解 Grunt CLI的执行原理，请<a
                            href="https://github.com/gruntjs/grunt-cli/blob/master/bin/grunt">阅读源码</a>。</p>
                <h2><a class="anchor" href="#grunt" name="grunt">拿一份现有的 Grunt 项目练手</a></h2>
                <p>假定Grunt CLI已经正确安装，并且已经有一份配置好<code>package.json</code> 和 <code>Gruntfile</code>
                    文件的项目了，接下来就很容易拿Grunt练手了：</p>
                <ol>
                    <li>将命令行的当前目录转到项目的根目录下。</li>
                    <li>执行<code>npm install</code>命令安装项目依赖的库。</li>
                    <li>执行 <code>grunt</code> 命令。</li>
                </ol>
                <p>OK，就是这么简单。还可以通过<code>grunt --help</code> 命令列出所有已安装的Grunt任务（task），但是一般更建议去查看项目的文档以获取帮助信息。</p>
                <h2><a class="anchor" href="#grunt" name="grunt">准备一份新的 Grunt 项目</a></h2>
                <p>一般需要在你的项目中添加两份文件：<code>package.json</code> 和 <code>Gruntfile</code>。</p>
                <p><strong>package.json</strong>: 此文件被<a href="https://npmjs.org/">npm</a>用于存储项目的元数据，以便将此项目发布为npm模块。你可以在此文件中列出项目依赖的grunt和Grunt插件，放置于<a
                            href="https://docs.npmjs.com/files/package.json#devdependencies">devDependencies</a>配置段内。
                </p>
                <p><strong>Gruntfile</strong>: 此文件被命名为 <code>Gruntfile.js</code> 或 <code>Gruntfile.coffee</code>，用来配置或定义任务（task）并加载Grunt插件的。
                    <strong>此文档中提到的 <code>Gruntfile</code> 其实说的是一个文件，文件名是 <code>Gruntfile.js</code> 或 <code>Gruntfile.coffee</code></strong>。
                </p>
                <h2><a class="anchor" href="#package.json" name="package.json">package.json</a></h2>
                <p><code>package.json</code>应当放置于项目的根目录中，与<code>Gruntfile</code>在同一目录中，并且应该与项目的源代码一起被提交。在上述目录(<code>package.json</code>所在目录)中运行<code>npm
                        install</code>将依据<code>package.json</code>文件中所列出的每个依赖来自动安装适当版本的依赖。</p>
                <p>下面列出了几种为你的项目创建<code>package.json</code>文件的方式：</p>
                <ul>
                    <li>大部分 <a href="/project-scaffolding">grunt-init</a> 模版都会自动创建特定于项目的<code>package.json</code>文件。
                    </li>
                    <li><a href="https://docs.npmjs.com/cli/init">npm init</a>命令会创建一个基本的<code>package.json</code>文件。
                    </li>
                    <li>复制下面的案例，并根据需要做扩充，参考此<a href="https://docs.npmjs.com/files/package.json">说明</a>.</li>
                </ul>
                <pre><code class="lang-js">{
  <span class="string">"name"</span>: <span class="string">"my-project-name"</span>,
  <span class="string">"version"</span>: <span class="string">"0.1.0"</span>,
  <span class="string">"devDependencies"</span>: {
    <span class="string">"grunt"</span>: <span class="string">"~0.4.5"</span>,
    <span class="string">"grunt-contrib-jshint"</span>: <span class="string">"~0.10.0"</span>,
    <span class="string">"grunt-contrib-nodeunit"</span>: <span class="string">"~0.4.1"</span>,
    <span class="string">"grunt-contrib-uglify"</span>: <span class="string">"~0.5.0"</span>
  }
}</code></pre>
                <h3><a class="anchor" href="#grunt-grunt" name="grunt-grunt">安装Grunt 和 grunt插件</a></h3>
                <p>向已经存在的<code>package.json</code> 文件中添加Grunt和grunt插件的最简单方式是通过<code>npm install &lt;module&gt;
                        --save-dev</code>命令。此命令不光安装了<code>&lt;module&gt;</code>，还会自动将其添加到<a
                            href="https://docs.npmjs.com/files/package.json#devdependencies">devDependencies</a> 配置段中，遵循<a
                            href="https://npmjs.org/doc/misc/semver.html#Ranges">tilde version range</a>格式。</p>
                <p>例如，下面这条命令将安装Grunt最新版本到项目目录中，并将其添加到devDependencies内：</p>
                <pre><code class="lang-shell">npm install grunt --save-dev</code></pre>
                <p>同样，grunt插件和其它node模块都可以按相同的方式安装。下面展示的实例就是安装 JSHint 任务模块：</p>
                <pre><code class="lang-shell">npm install grunt-contrib-jshint --save-dev</code></pre>
                <p>在 <a href="/plugins">Grunt 插件</a> 页面可以看到当前可用的 Grunt 插件，他们可以直接在项目中安装并使用。</p>
                <p>安装插件之后，请务必确保将更新之后的 <code>package.json</code> 文件提交到项目仓库中。</p>
                <h2><a class="anchor" href="#gruntfile" name="gruntfile">Gruntfile</a></h2>
                <p><code>Gruntfile.js</code> 或 <code>Gruntfile.coffee</code> 文件是有效的 JavaScript 或 CoffeeScript
                    文件，应当放在你的项目根目录中，和<code>package.json</code>文件在同一目录层级，并和项目源码一起加入源码管理器。</p>
                <p>Gruntfile由以下几部分构成：</p>
                <ul>
                    <li>"wrapper" 函数</li>
                    <li>项目与任务配置</li>
                    <li>加载grunt插件和任务</li>
                    <li>自定义任务</li>
                </ul>
                <h3><a class="anchor" href="#gruntfile" name="gruntfile">Gruntfile文件案例</a></h3>
                <p>在下面列出的这个 <code>Gruntfile</code> 中，<code>package.json</code>文件中的项目元数据（metadata）被导入到 Grunt 配置中， <a
                            href="http://github.com/gruntjs/grunt-contrib-uglify">grunt-contrib-uglify</a> 插件中的<code>uglify</code>
                    任务（task）被配置为压缩（minify）源码文件并依据上述元数据动态生成一个文件头注释。当在命令行中执行 <code>grunt</code> 命令时，<code>uglify</code>
                    任务将被默认执行。</p>
                <pre><code class="lang-js">module.exports = <span class="keyword">function</span>(grunt) {

  <span class="comment">// Project configuration.</span>
  grunt.initConfig({
    pkg: grunt.file.readJSON(<span class="string">'package.json'</span>),
    uglify: {
      options: {
        banner: <span class="string">'/*! &lt;%= pkg.name %&gt; &lt;%= grunt.template.today("yyyy-mm-dd") %&gt; */\n'</span>
      },
      build: {
        src: <span class="string">'src/&lt;%= pkg.name %&gt;.js'</span>,
        dest: <span class="string">'build/&lt;%= pkg.name %&gt;.min.js'</span>
      }
    }
  });

  <span class="comment">// 加载包含 "uglify" 任务的插件。</span>
  grunt.loadNpmTasks(<span class="string">'grunt-contrib-uglify'</span>);

  <span class="comment">// 默认被执行的任务列表。</span>
  grunt.registerTask(<span class="string">'default'</span>, [<span class="string">'uglify'</span>]);

};</code></pre>
                <p>前面已经向你展示了整个 <code>Gruntfile</code>，接下来将详细解释其中的每一部分。</p>
                <h3><a class="anchor" href="#wrapper" name="wrapper">"wrapper" 函数</a></h3>
                <p>每一份 <code>Gruntfile</code> （和grunt插件）都遵循同样的格式，你所书写的Grunt代码必须放在此函数内：</p>
                <pre><code class="lang-js">module.exports = <span class="keyword">function</span>(grunt) {
  <span class="comment">// Do grunt-related things in here</span>
};</code></pre>
                <h3>项目和任务配置</h3>
                <p>大部分的Grunt任务都依赖某些配置数据，这些数据被定义在一个object内，并传递给<a href="/grunt#grunt.initconfig">grunt.initConfig</a> 方法。
                </p>
                <p>在下面的案例中，<code>grunt.file.readJSON('package.json')</code> 将存储在<code>package.json</code>文件中的JSON元数据引入到grunt
                    config中。 由于<code>&lt;% %&gt;</code>模板字符串可以引用任意的配置属性，因此可以通过这种方式来指定诸如文件路径和文件列表类型的配置数据，从而减少一些重复的工作。</p>
                <p>
                    你可以在这个配置对象中(传递给initConfig()方法的对象)存储任意的数据，只要它不与你任务配置所需的属性冲突，否则会被忽略。此外，由于这本身就是JavaScript，你不仅限于使用JSON；你可以在这里使用任意的有效的JS代码。如果有必要，你甚至可以以编程的方式生成配置。</p>
                <p>与大多数task一样，<a href="http://github.com/gruntjs/grunt-contrib-uglify">grunt-contrib-uglify</a>
                    插件中的<code>uglify</code> 任务要求它的配置被指定在一个同名属性中。在这里有一个例子, 我们指定了一个<code>banner</code>选项(用于在文件顶部生成一个注释)，紧接着是一个单一的名为<code>build</code>的uglify目标，用于将一个js文件压缩为一个目标文件。
                </p>
                <pre><code class="lang-js"><span class="comment">// Project configuration.</span>
grunt.initConfig({
  pkg: grunt.file.readJSON(<span class="string">'package.json'</span>),
  uglify: {
    options: {
      banner: <span class="string">'/*! &lt;%= pkg.name %&gt; &lt;%= grunt.template.today("yyyy-mm-dd") %&gt; */\n'</span>
    },
    build: {
      src: <span class="string">'src/&lt;%= pkg.name %&gt;.js'</span>,
      dest: <span class="string">'build/&lt;%= pkg.name %&gt;.min.js'</span>
    }
  }
});</code></pre>
                <h3><a class="anchor" href="#grunt" name="grunt">加载 Grunt 插件和任务</a></h3>
                <p>像 <a href="https://github.com/gruntjs/grunt-contrib-concat">concatenation</a>、[minification]、<a
                            href="http://github.com/gruntjs/grunt-contrib-uglify">grunt-contrib-uglify</a> 和 <a
                            href="https://github.com/gruntjs/grunt-contrib-jshint">linting</a>这些常用的任务（task）都已经以<a
                            href="https://github.com/gruntjs">grunt插件</a>的形式被开发出来了。只要在 <code>package.json</code>
                    文件中被列为dependency（依赖）的包，并通过<code>npm install</code>安装之后，都可以在<code>Gruntfile</code>中以简单命令的形式使用：</p>
                <pre><code class="lang-js"><span class="comment">// 加载能够提供"uglify"任务的插件。</span>
grunt.loadNpmTasks(<span class="string">'grunt-contrib-uglify'</span>);</code></pre>
                <p><strong>注意：</strong> <code>grunt --help</code> 命令将列出所有可用的任务。</p>
                <h3>自定义任务</h3>
                <p>通过定义 <code>default</code> 任务，可以让Grunt默认执行一个或多个任务。在下面的这个案例中，执行 <code>grunt</code>
                    命令时如果不指定一个任务的话，将会执行<code>uglify</code>任务。这和执行<code>grunt uglify</code> 或者 <code>grunt default</code>的效果一样。<code>default</code>任务列表数组中可以指定任意数目的任务（可以带参数）。
                </p>
                <pre><code class="lang-js"><span class="comment">// Default task(s).</span>
grunt.registerTask(<span class="string">'default'</span>, [<span class="string">'uglify'</span>]);</code></pre>
                <p>如果Grunt插件中的任务（task）不能满足你的项目需求，你还可以在<code>Gruntfile</code>中自定义任务（task）。例如，在下面的 <code>Gruntfile</code>
                    中自定义了一个<code>default</code> 任务，并且他甚至不依赖任务配置：</p>
                <pre><code class="lang-js">module.exports = <span class="keyword">function</span>(grunt) {

  <span class="comment">// A very basic default task.</span>
  grunt.registerTask(<span class="string">'default'</span>, <span class="string">'Log some stuff.'</span>, <span
                                class="keyword">function</span>() {
    grunt.log.write(<span class="string">'Logging some stuff...'</span>).ok();
  });

};</code></pre>
                <p>特定于项目的任务不必在 <code>Gruntfile</code> 中定义。他们可以定义在外部<code>.js</code> 文件中，并通过<a
                            href="/grunt/#grunt.loadtasks">grunt.loadTasks</a> 方法加载。</p>
                <h2>扩展阅读</h2>
                <ul>
                    <li>The <a href="/installing-grunt/">Installing grunt</a> guide has detailed information about
                        installing specific, production or in-development, versions of Grunt and grunt-cli.
                    </li>
                    <li>The <a href="/configuring-tasks/">Configuring Tasks</a> guide has an in-depth explanation on how
                        to configure tasks, targets, options and files inside the <code>Gruntfile</code>, along with an
                        explanation of templates, globbing patterns and importing external data.
                    </li>
                    <li>The <a href="/creating-tasks/">Creating Tasks</a> guide lists the differences between the types
                        of Grunt tasks and shows a number of sample tasks and configurations.
                    </li>
                    <li>For more information about writing custom tasks or Grunt plugins, check out the <a
                                href="/grunt">developer documentation</a>.
                    </li>
                </ul>
                <div class="end-link">Found an error in the documentation?
                    <a href="https://github.com/gruntjs/grunt-docs/issues">File an issue</a>.
                </div>
            </div>
        </div>
    </div>
</div>