services.factory("OnlineUsersFactory",["$http","$q",function(e,n){return this.loadOnlineUsers=function(i){var t=n.defer();return e.get(WWW_DIR_JAVASCRIPT+"chat/onlineusers/(method)/ajax/(timeout)/"+i.timeout+(i.department>0?"/(department)/"+i.department:"")+(i.max_rows>0?"/(maxrows)/"+i.max_rows:"")+(""!=i.country?"/(country)/"+i.country:"")+(""!=i.time_on_site?"/(timeonsite)/"+encodeURIComponent(i.time_on_site):"")).then((function(e){t.resolve(e.data)})),t.promise},this.deleteOnlineUser=function(i){var t=n.defer();return e.post(WWW_DIR_JAVASCRIPT+"chat/onlineusers/(deletevisitor)/"+i.user_id+"/(csfr)/"+confLH.csrf_token).then((function(e){void 0!==e.error_url?document.location=e.data.error_url:t.resolve(e.data)})),t.promise},this}]),lhcAppControllers.controller("OnlineCtrl",["$scope","$http","$location","$rootScope","$log","$interval","OnlineUsersFactory",function(e,n,i,t,o,s,r){var a;this.onlineusers=[],this.onlineusersPreviousID=[],e.onlineusersGrouped=[],this.updateTimeout="10",this.userTimeout="3600",this.maxRows="50",this.department="0",this.country="none",this.predicate="last_visit",this.time_on_site="",this.reverse=!0,this.wasInitiated=!1,this.forbiddenVisitors=!1,this.soundEnabled=!1,this.notificationEnabled=!1,e.groupByField="none";var u=this;e.groupBy=function(n){var i,t;e.onlineusersGrouped=[],i=u.onlineusers,t=n,i.sort((function(e,n){return e[t]<=n[t]?-1:1}));for(var o="_INVALID_GROUP_VALUE_",s=0;s<u.onlineusers.length;s++){var r=u.onlineusers[s];if(r[n]!==o){var a={label:r[n],id:s,ou:[]};o=a.label,e.onlineusersGrouped.push(a)}a.ou.push(r)}},this.updateList=function(){1!=lhinst.disableSync&&1!=u.forbiddenVisitors&&r.loadOnlineUsers({timeout:u.userTimeout,time_on_site:u.time_on_site,department:u.department,country:u.country,max_rows:u.maxRows}).then((function(n){if(u.onlineusers=n,"none"!=e.groupByField?e.groupBy(e.groupByField):(e.onlineusersGrouped=[],e.onlineusersGrouped.push({label:"",id:0,ou:u.onlineusers})),u.notificationEnabled||u.soundEnabled){var i=!1,t=[];if(angular.forEach(u.onlineusers,(function(e,n){var o=!0;-1==u.onlineusersPreviousID.indexOf(e.id)&&(o=!1,u.onlineusersPreviousID.push(e.id)),1==u.wasInitiated&&0==o&&(i=!0,t.push(e))})),1==i){if(u.soundEnabled&&Modernizr.audio){var o=new Audio;o.src=Modernizr.audio.ogg?WWW_DIR_JAVASCRIPT_FILES+"/new_visitor.ogg":Modernizr.audio.mp3?WWW_DIR_JAVASCRIPT_FILES+"/new_visitor.mp3":WWW_DIR_JAVASCRIPT_FILES+"/new_visitor.wav",o.load(),setTimeout((function(){o.play()}),500)}u.notificationEnabled&&(window.webkitNotifications||window.Notification)&&angular.forEach(t,(function(e,n){if(window.webkitNotifications)0==window.webkitNotifications.checkPermission()&&((i=window.webkitNotifications.createNotification(WWW_DIR_JAVASCRIPT_FILES_NOTIFICATION+"/notification.png",e.ip+(""!=e.user_country_name?", "+e.user_country_name:""),(""!=e.page_title?e.page_title+"\n-----\n":"")+(""!=e.referrer?e.referrer+"\n-----\n":""))).onclick=function(){i.cancel()},i.show(),setTimeout((function(){i.cancel()}),15e3));else if(window.Notification){var i;"granted"==window.Notification.permission&&((i=new Notification(e.ip+(""!=e.user_country_name?", "+e.user_country_name:""),{icon:WWW_DIR_JAVASCRIPT_FILES_NOTIFICATION+"/notification.png",body:(""!=e.page_title?e.page_title+"\n-----\n":"")+(""!=e.referrer?e.referrer+"\n-----\n":"")})).onclick=function(){i.close()},setTimeout((function(){i.close()}),15e3))}}))}u.wasInitiated=!0,u.onlineusersPreviousID.length>100&&(u.wasInitiated=!1,u.onlineusersPreviousID=[])}}))},a=s((function(){0==u.forbiddenVisitors?u.updateList():s.cancel(a)}),1e3*this.updateTimeout),e.$watch("online.updateTimeout",(function(e,n){e!=n&&(s.cancel(a),a=s((function(){u.updateList()}),1e3*e),lhinst.changeUserSettingsIndifferent("oupdate_timeout",e))})),e.$watch("online.userTimeout",(function(e,n){e!=n&&lhinst.changeUserSettingsIndifferent("ouser_timeout",e)})),e.$watch("online.country",(function(e,n){e!=n&&lhinst.changeUserSettingsIndifferent("ocountry",e)})),e.$watch("online.time_on_site",(function(e,n){e!=n&&lhinst.changeUserSettingsIndifferent("otime_on_site",""==e?"none":e)})),e.$watch("online.maxRows",(function(e,n){e!=n&&lhinst.changeUserSettingsIndifferent("omax_rows",e)})),e.$watch("online.department",(function(e,n){e!=n&&lhinst.changeUserSettingsIndifferent("o_department",e)})),e.$watch("groupByField",(function(e,n){e!=n&&lhinst.changeUserSettingsIndifferent("ogroup_by",e)})),e.$watch("online.userTimeout + online.department + online.maxRows + groupByField + online.country + online.time_on_site",(function(e,n){setTimeout((function(){u.updateList()}),500)})),this.showOnlineUserInfo=function(e){lhc.revealModal({url:WWW_DIR_JAVASCRIPT+"chat/getonlineuserinfo/"+e})},this.previewChat=function(e){e.chat_id>0&&1==e.can_view_chat&&lhc.revealModal({url:WWW_DIR_JAVASCRIPT+"chat/previewchat/"+e.chat_id})},this.sendMessage=function(e){lhc.revealModal({url:WWW_DIR_JAVASCRIPT+"chat/sendnotice/"+e})},this.deleteUser=function(e,n){confirm(n)&&r.deleteOnlineUser({user_id:e.id}).then((function(n){u.onlineusers.splice(u.onlineusers.indexOf(e),1)}))},this.disableNewUserBNotif=function(){u.notificationEnabled=!u.notificationEnabled,lhinst.changeUserSettings("new_user_bn",1==u.notificationEnabled?1:0)},this.disableNewUserSound=function(){u.soundEnabled=!u.soundEnabled,lhinst.changeUserSettings("new_user_sound",1==u.soundEnabled?1:0)},e.$on("$destroy",(function(){s.cancel(a)}))}]);
//# sourceMappingURL=7860b2322693217000e499b70447fa0c.js.map
