Live helper chat完全汉化版
==============

它是一个开源的应用程序，它在一个地方带来了简单性和可用性。通过实时助手聊天，您可以在您的网站上免费提供实时支持。

## 需要帮助?
* Documentation - https://doc.livehelperchat.com
* Forum - https://forum.livehelperchat.com/
* Chat (Discord) https://discord.gg/YsZXQVh
* [Laravel version of Live Helper Chat](https://github.com/LiveHelperChat/livehelperchat_laravel)

## 演示

http://livehelperchat.com/demo-12c.html

## 插件

 * [Mobile app](https://github.com/LiveHelperChat/lhc_messenger) flutter
 * [Voice & Video & ScreenShare](https://doc.livehelperchat.com/docs/voice-video-screenshare) powered by [agora](https://www.agora.io/en/)
 * [Rest API](https://api.livehelperchat.com)
 * [Bot](https://doc.livehelperchat.com/docs/how-to-use-bot) with possibility to integrate any third party AI
 * [Telegram](https://github.com/LiveHelperChat/telegram)
 * [Rasa](https://doc.livehelperchat.com/docs/bot/rasa-integration)
 * [Mattermost](https://github.com/LiveHelperChat/mattermost)
 * [Facebook messenger](https://github.com/LiveHelperChat/fbmessenger)
 * [Insult detection](https://github.com/LiveHelperChat/lhcinsult) powered by [DeepPavlov.ai](https://demo.deeppavlov.ai/#/en/insult) and [NudeNet](https://github.com/notAI-tech/NudeNet)
 * [SMS, WhatsApp](https://github.com/LiveHelperChat/twilio) (Twilio based)
 * [WhatsApp](https://doc.livehelperchat.com/docs/integrating/whatsapp) open-wa based.
 * [Elasticsearch](https://github.com/LiveHelperChat/elasticsearch) get statistic for millions of chats in seconds
 * [Node.js](https://github.com/LiveHelperChat/NodeJS-Helper)
 * [Docker](https://github.com/LiveHelperChat/docker-standalone)
 * [Background worker for heavy tasks](https://github.com/LiveHelperChat/lhc-php-resque) offload Rest API calls
 * Integrate any [third party Rest API](https://doc.livehelperchat.com/docs/bot/rest-api)
 * [Google Authentication](https://github.com/LiveHelperChat/lhcgoogleauth) login using Google account
 * [2FA](https://github.com/LiveHelperChat/2fa) `Authenticator` mobile app support
 * [Amazon S3](https://github.com/LiveHelperChat/amazon-s3) scale infinitely by storing app files in the cloud
 * [Desktop app](https://github.com/LiveHelperChat/electron) written with electron
 * [Sentiment analysis using DeepPavlov](https://github.com/LiveHelperChat/sentiment)

## 开发指南
 * 安装应用程序后禁用缓存并启用调试输出。
   * https://github.com/LiveHelperChat/livehelperchat/blob/master/lhc_web/settings/settings.ini.default.php#L13-L16
   * 将以下值更改为
    ```
    * debug_output => true
   * templatecache => false
   * templatecompile => false
   * modulecompile => false
   ```
 * 要编译lhc_web文件夹中的JS，请执行。这将编译主JS和旧的小工具javascript文件。
   * `npm install && gulp`
 * 编译新的widget V2
   * There is two apps [wrapper](https://github.com/LiveHelperChat/livehelperchat/tree/master/lhc_web/design/defaulttheme/widget/wrapper) and [widget](https://github.com/LiveHelperChat/livehelperchat/tree/master/lhc_web/design/defaulttheme/widget/react-app)
   * `cd lhc_web/design/defaulttheme/widget/wrapper && npm install && npm run build`
   * `cd lhc_web/design/defaulttheme/widget/react-app && npm install && npm run build && npm run build-ie`
 * 重新编译静态JS/CSS文件。如果你改变了核心JS文件，就需要这样做。如果使用了不止一个服务器，它还可以避免丢失CSS/JS文件。
   * `php cron.php -s site_admin -c cron/util/generate_css -p 1 && gulp js-static`

## 扩展
https://github.com/LiveHelperChat

## 翻译贡献
https://www.transifex.com/projects/p/live-helper-chat/

## 文件夹结构

 * Directories content:
  * lhc_web - WEB application folder.
 
## 特点

几个主要特点

 * [Bot](https://doc.livehelperchat.com/docs/how-to-use-bot) 可以集成任何第三方人工智能
 * XMPP 支持有关新聊天的通知. (IPhone, IPad, Android, Blackberry, GTalk etc...)
 * Chrome 扩展程序
 * 可重复的声音通知
 * Work hours
 * See what user see with screenshot feature
 * Drag & Drop widgets, minimize/maximize widgets
 * Multiple chats same time
 * See what users are typing before they send a message
 * Multiple operators
 * Send delayed canned messages as it was real user typing
 * Chats archive
 * Priority queue
 * Chats statistic generation, top chats
 * Resume chat after user closed chat
 * All chats in single window with tabs interface, tabs are remembered before they are closed
 * Chat transcript print
 * Chat transcript send by mail
 * Site widget
 * Page embed mode for live support script or widget mode, or standard mode.
 * Multilanguage
 * Chats transfering
 * Departments
 * Files upload
 * Chat search
 * Automatic transfers between departments
 * Option to generate JS for different departments
 * Option to prefill form fields. 
 * Option to add custom form fields. It can be either user variables or hidden fields. Usefull if you are integrating with third party system and want to pass user_id for example.
 * Cronjobs
 * Callbacks
 * Closed chat callback
 * Unanswered chat callback
 * Asynchronous status loading, not blocking site javascript.
 * XML, JSON export module
 * Option to send transcript to users e-mail
 * SMTP support
 * HTTPS support
 * No third parties cookies dependency
 * Previous users chats
 * Online users tracking, including geo detection
 * GEO detection using three different sources
 * Option to configure start chat fields
 * Sounds on pending chats and new messages
 * Google chrome notifications on pending messages.
 * Browser title blinking then there is pending message.
 * Option to limit pro active chat invitation messages based on pending chats.
 * Option to configure frequency for pro active chat invitation message. You can set after how many hours for the same user invitation message should be shown again.
 * Users blocking
 * Top performance with enabled cache
 * Windows, Linux and Mac native applications.
 * Advanced embed code generation with numerous options of includable code.
 * Template override system
 * Module override system
 * Support for custom extensions
 * Changeable footer and header content
 * Option to send messges to anonymous site visitors,
 * Canned messages
 * Informing then operator or user is typing.
 * Option to see what user is typing before he sends a message
 * Canned messages for desktop client
 * Voting module
 * FAQ module
 * Online users map
 * Pro active chat invitatio
 * Remember me functionality
 * Total pageviews tracking
 * Total pageviews including previous visits tracking
 * Visits tracking, how many times user has been on your page.
 * Time spent on site
 * Auto responder
 * BB Code support. Links recognition. Smiles and few other hidden features :)
 * First user visit tracking
 * Option for customers mute sounds 
 * Option for operators mute messages sounds and new pending chat's sound.
 * Option to monitor online operators.
 * Option to have different pro active messages for different domains. This can be archieved using different identifiers.
 * Dekstop client supports HTTPS
 * Protection against spammers using advanced captcha technique without requiring users to enter any captcha code.
 * Option for operator set online or offline mode.
 * Desktop client for
  * Windows
  * Linux 
  * Mac
 * Flexible permission system:
  * Roles
  * Groups
  * Users

Forum:
http://forum.livehelperchat.com/
