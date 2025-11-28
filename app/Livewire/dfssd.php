<?xml version="1.0" encoding="UTF-8"?>
<configuration>
  <configSections>
    <section name="urlrewritingnet" requirePermission="false" type="UrlRewritingNet.Configuration.UrlRewriteSection, UrlRewritingNet.UrlRewriter" />
    <sectionGroup name="system.web.extensions" type="System.Web.Configuration.SystemWebExtensionsSectionGroup, System.Web.Extensions, Version=3.5.0.0, Culture=neutral, PublicKeyToken=31BF3856AD364E35">
      <sectionGroup name="scripting" type="System.Web.Configuration.ScriptingSectionGroup, System.Web.Extensions, Version=3.5.0.0, Culture=neutral, PublicKeyToken=31BF3856AD364E35">
        <section name="scriptResourceHandler" type="System.Web.Configuration.ScriptingScriptResourceHandlerSection, System.Web.Extensions, Version=3.5.0.0, Culture=neutral, PublicKeyToken=31BF3856AD364E35" requirePermission="false" allowDefinition="MachineToApplication" />
        <sectionGroup name="webServices" type="System.Web.Configuration.ScriptingWebServicesSectionGroup, System.Web.Extensions, Version=3.5.0.0, Culture=neutral, PublicKeyToken=31BF3856AD364E35">
          <section name="jsonSerialization" type="System.Web.Configuration.ScriptingJsonSerializationSection, System.Web.Extensions, Version=3.5.0.0, Culture=neutral, PublicKeyToken=31BF3856AD364E35" requirePermission="false" allowDefinition="Everywhere" />
          <section name="profileService" type="System.Web.Configuration.ScriptingProfileServiceSection, System.Web.Extensions, Version=3.5.0.0, Culture=neutral, PublicKeyToken=31BF3856AD364E35" requirePermission="false" allowDefinition="MachineToApplication" />
          <section name="authenticationService" type="System.Web.Configuration.ScriptingAuthenticationServiceSection, System.Web.Extensions, Version=3.5.0.0, Culture=neutral, PublicKeyToken=31BF3856AD364E35" requirePermission="false" allowDefinition="MachineToApplication" />
          <section name="roleService" type="System.Web.Configuration.ScriptingRoleServiceSection, System.Web.Extensions, Version=3.5.0.0, Culture=neutral, PublicKeyToken=31BF3856AD364E35" requirePermission="false" allowDefinition="MachineToApplication" />
        </sectionGroup>
      </sectionGroup>
    </sectionGroup>
  </configSections>
  <appSettings>
  </appSettings>
  <connectionStrings>
    <add name="School_ConnectionString" connectionString="Data Source=208.91.198.174,1433;Initial Catalog=srikadb;User ID=srikadb;Password=LNm2hy~Yqs$04ncb;TrustServerCertificate=True;" providerName="System.Data.SqlClient" />
  </connectionStrings>
  <system.web>
    <httpRuntime maxRequestLength="4096" />
    <customErrors mode="Off" />
    <!--<customErrors mode="On" defaultRedirect="/error.aspx?type=error">
      <error statusCode="404" redirect="404.aspx" />
    </customErrors>-->
    <!--  Set compilation debug="true" to insert debugging GET,HEAD,POST,DEBUG
            symbols into the compiled page. Because this 
            affects performance, set this value to true only 
            during development.
        -->
    <compilation debug="true" tempDirectory="D:\INETPUB\VHOSTS\srikanchimahaswamividyamandir.edu.in\tmp" defaultLanguage="c#">
      <assemblies>
        <add assembly="System.Core, Version=3.5.0.0, Culture=neutral, PublicKeyToken=B77A5C561934E089" />
        <add assembly="System.Web.Extensions, Version=3.5.0.0, Culture=neutral, PublicKeyToken=31BF3856AD364E35" />
        <add assembly="System.Data.DataSetExtensions, Version=3.5.0.0, Culture=neutral, PublicKeyToken=B77A5C561934E089" />
        <add assembly="System.Xml.Linq, Version=3.5.0.0, Culture=neutral, PublicKeyToken=B77A5C561934E089" />
        <add assembly="System.Design, Version=2.0.0.0, Culture=neutral, PublicKeyToken=B03F5F7F11D50A3A" />
        <add assembly="System.Web.Extensions.Design, Version=3.5.0.0, Culture=neutral, PublicKeyToken=31BF3856AD364E35" />
        <add assembly="System.Windows.Forms, Version=2.0.0.0, Culture=neutral, PublicKeyToken=B77A5C561934E089" />
      </assemblies>
    </compilation>
    <!--<authentication mode="Windows"/>-->
    <pages>
      <controls>
        <add tagPrefix="asp" namespace="System.Web.UI" assembly="System.Web.Extensions, Version=3.5.0.0, Culture=neutral, PublicKeyToken=31BF3856AD364E35" />
        <add tagPrefix="asp" namespace="System.Web.UI.WebControls" assembly="System.Web.Extensions, Version=3.5.0.0, Culture=neutral, PublicKeyToken=31BF3856AD364E35" />
      </controls>
    </pages>
    <httpHandlers>
      <remove verb="*" path="*.asmx" />
      <add verb="*" path="*.asmx" validate="false" type="System.Web.Script.Services.ScriptHandlerFactory, System.Web.Extensions, Version=3.5.0.0, Culture=neutral, PublicKeyToken=31BF3856AD364E35" />
      <add verb="*" path="*_AppService.axd" validate="false" type="System.Web.Script.Services.ScriptHandlerFactory, System.Web.Extensions, Version=3.5.0.0, Culture=neutral, PublicKeyToken=31BF3856AD364E35" />
      <add verb="GET,HEAD" path="ScriptResource.axd" type="System.Web.Handlers.ScriptResourceHandler, System.Web.Extensions, Version=3.5.0.0, Culture=neutral, PublicKeyToken=31BF3856AD364E35" validate="false" />
    </httpHandlers>
    <httpModules>
      <add name="UrlRewriteModule" type="UrlRewritingNet.Web.UrlRewriteModule, UrlRewritingNet.UrlRewriter" />
      <add name="ScriptModule" type="System.Web.Handlers.ScriptModule, System.Web.Extensions, Version=3.5.0.0, Culture=neutral, PublicKeyToken=31BF3856AD364E35" />
    </httpModules>
    <!--<sessionState />-->
  </system.web>
  <system.codedom>
    <compilers>
      <compiler language="c#;cs;csharp" extension=".cs" warningLevel="4" type="Microsoft.CSharp.CSharpCodeProvider,System, Version=2.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089">
        <providerOption name="CompilerVersion" value="v3.5" />
        <providerOption name="WarnAsError" value="false" />
      </compiler>
      <compiler language="vb;vbs;visualbasic;vbscript" extension=".vb" warningLevel="4" type="Microsoft.VisualBasic.VBCodeProvider, System, Version=2.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089">
        <providerOption name="CompilerVersion" value="v3.5" />
        <providerOption name="OptionInfer" value="true" />
        <providerOption name="WarnAsError" value="false" />
      </compiler>
    </compilers>
  </system.codedom>
  <system.webServer>
    <rewrite>
      <rules>
        <rule name="Redirect to WWW" stopProcessing="true">
          <match url=".*" />
          <conditions>
            <add input="{HTTP_HOST}" pattern="^srikanchimahaswamividyamandir.edu.in$" />
          </conditions>
          <action type="Redirect" url="http://www.srikanchimahaswamividyamandir.edu.in/{R:0}" redirectType="Permanent" />
        </rule>
      </rules>
      <outboundRules>
        <rule name="Remove ETag">
          <match serverVariable="RESPONSE_ETag" pattern=".+" />
          <action type="Rewrite" value="" />
        </rule>
      </outboundRules>
    </rewrite>
    <validation validateIntegratedModeConfiguration="false" />
    <modules>
      <remove name="ScriptModule-4.0" />
      <remove name="UrlRoutingModule-4.0" />
      <remove name="ServiceModel" />
      <remove name="ScriptModule" />
      <add name="ScriptModule" preCondition="managedHandler" type="System.Web.Handlers.ScriptModule, System.Web.Extensions, Version=3.5.0.0, Culture=neutral, PublicKeyToken=31BF3856AD364E35" />
      <add name="ErrorHandlerModule" type="System.Web.Mobile.ErrorHandlerModule, System.Web.Mobile, Version=2.0.0.0, Culture=neutral, PublicKeyToken=b03f5f7f11d50a3a" preCondition="managedHandler" />
      <add name="ServiceModel" type="System.ServiceModel.Activation.HttpModule, System.ServiceModel, Version=3.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089" preCondition="managedHandler" />
      <add name="UrlRewriteModule" type="UrlRewritingNet.Web.UrlRewriteModule, UrlRewritingNet.UrlRewriter" preCondition="managedHandler" />
    </modules>
    <handlers>
      <remove name="WebServiceHandlerFactory-Integrated" />
      <remove name="ScriptHandlerFactory" />
      <remove name="ScriptHandlerFactoryAppServices" />
      <remove name="ScriptResource" />
      <add name="*.rem_*" path="*.rem" verb="*" type="System.Runtime.Remoting.Channels.Http.HttpRemotingHandlerFactory, System.Runtime.Remoting, Version=2.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089" preCondition="integratedMode,runtimeVersionv2.0" />
      <add name="*.soap_*" path="*.soap" verb="*" type="System.Runtime.Remoting.Channels.Http.HttpRemotingHandlerFactory, System.Runtime.Remoting, Version=2.0.0.0, Culture=neutral, PublicKeyToken=b77a5c561934e089" preCondition="integratedMode,runtimeVersionv2.0" />
      <add name="ScriptHandlerFactory" verb="*" path="*.asmx" preCondition="integratedMode" type="System.Web.Script.Services.ScriptHandlerFactory, System.Web.Extensions, Version=3.5.0.0, Culture=neutral, PublicKeyToken=31BF3856AD364E35" />
      <add name="ScriptHandlerFactoryAppServices" verb="*" path="*_AppService.axd" preCondition="integratedMode" type="System.Web.Script.Services.ScriptHandlerFactory, System.Web.Extensions, Version=3.5.0.0, Culture=neutral, PublicKeyToken=31BF3856AD364E35" />
      <add name="ScriptResource" preCondition="integratedMode" verb="GET,HEAD" path="ScriptResource.axd" type="System.Web.Handlers.ScriptResourceHandler, System.Web.Extensions, Version=3.5.0.0, Culture=neutral, PublicKeyToken=31BF3856AD364E35" />
    </handlers>
    <defaultDocument>
      <files>
        <clear />
        <add value="default.aspx" />
      </files>
    </defaultDocument>
    <directoryBrowse enabled="true" />
    <httpErrors>
      <remove statusCode="401" />
      <error statusCode="401" path="401.htm" />
      <remove statusCode="403" />
      <error statusCode="403" path="403.htm" />
      <remove statusCode="404" />
      <error statusCode="404" path="404.htm" />
      <remove statusCode="405" />
      <error statusCode="405" path="405.htm" />
      <remove statusCode="406" />
      <error statusCode="406" path="406.htm" />
      <remove statusCode="412" />
      <error statusCode="412" path="412.htm" />
      <remove statusCode="500" />
      <error statusCode="500" path="500.htm" />
      <remove statusCode="501" />
      <error statusCode="501" path="501.htm" />
      <remove statusCode="502" />
      <error statusCode="502" path="502.htm" />
    </httpErrors>
    <tracing>
      <traceFailedRequests>
        <clear />
      </traceFailedRequests>
    </tracing>
  </system.webServer>
  <runtime>
    <assemblyBinding xmlns="urn:schemas-microsoft-com:asm.v1" appliesTo="v2.0.50727">
      <dependentAssembly>
        <assemblyIdentity name="System.Web.Extensions" publicKeyToken="31bf3856ad364e35" />
        <bindingRedirect oldVersion="1.0.0.0-1.1.0.0" newVersion="3.5.0.0" />
      </dependentAssembly>
      <dependentAssembly>
        <assemblyIdentity name="System.Web.Extensions.Design" publicKeyToken="31bf3856ad364e35" />
        <bindingRedirect oldVersion="1.0.0.0-1.1.0.0" newVersion="3.5.0.0" />
      </dependentAssembly>
    </assemblyBinding>
  </runtime>
</configuration>