<?php

try {
    erLhcoreClassRestAPIHandler::validateRequest();

    if (!erLhcoreClassRestAPIHandler::hasAccessTo('lhgroupchat', 'use')) {
        throw new Exception('You do not have permission to use group chats.');
    }

    $operators = array(
        (int)$Params['user_parameters']['id'],
        isset($Params['user_parameters']['initiator_user_id']) && $Params['user_parameters']['initiator_user_id'] > 0 ? (int)$Params['user_parameters']['initiator_user_id'] : (int)erLhcoreClassRestAPIHandler::getUserId()
    );

    $db = ezcDbInstance::get();
    $db->beginTransaction();

    // We need to find a private chat where only we are the members with another operator
    $sql = "SELECT DISTINCT `lh_group_chat`.`id`,count(`lh_group_chat_member`.`id`) as `tm_live` FROM `lh_group_chat`
INNER JOIN lh_group_chat_member ON `lh_group_chat_member`.`group_id` = `lh_group_chat`.`id`
WHERE 
`lh_group_chat_member`.`user_id` IN (". implode(',',$operators) . ") AND
`lh_group_chat`.`type` = 1 AND
`lh_group_chat`.`tm` = 2 
GROUP BY `lh_group_chat`.`id`
HAVING
`tm_live` = 2";

    $stmt = $db->prepare($sql);
    $stmt->execute();
    $chatId = $stmt->fetch(PDO::FETCH_COLUMN);

    if (is_numeric($chatId)) {
        $groupChat = erLhcoreClassModelGroupChat::fetch($chatId);
    } else {

        $userOwner = erLhcoreClassModelUser::fetch($operators[1]);

        $operator = erLhcoreClassModelUser::fetch((int)$Params['user_parameters']['id']);

        function getLetters($word) {
            $letters = '';
            $inviter = explode(' ',trim($word));
            if (isset($inviter[0])) {
                $letters .= mb_strtoupper($inviter[0][0]);
                if (!isset($inviter[1])) {
                    $letters .= mb_strtoupper($inviter[0][1]);
                }
                if (isset($inviter[1])) {
                    $letters .= mb_strtoupper($inviter[1][0]);
                }
            }
            return $letters;
        }

        $letterName[] = getLetters($operator->name_official);
        $letterName[] = '&';
        $letterName[] = getLetters($userOwner->name_official);

        // Create a group chat
        $groupChat = new erLhcoreClassModelGroupChat();
        $groupChat->name = implode(' ',$letterName);
        $groupChat->type = 1;
        $groupChat->user_id = $userOwner->id;
        $groupChat->time = time();
        $groupChat->tm = 2;
        $groupChat->saveThis();

        $msg = new erLhcoreClassModelGroupMsg();
        $msg->msg = (string)$userOwner->name_official . ' ' . erTranslationClassLhTranslation::getInstance()->getTranslation('chat/adminchat','has invited') . ' ' . $operator->name_official . ' ' . erTranslationClassLhTranslation::getInstance()->getTranslation('chat/adminchat','for the private chat.');
        $msg->chat_id = $groupChat->id;
        $msg->user_id = -1;
        $msg->time = time();
        $msg->saveThis();

        $groupChat->last_msg_id = $msg->id;
        $groupChat->updateThis(array('update' => array('last_msg_id')));

        // Create a member
        $newMember = new erLhcoreClassModelGroupChatMember();
        $newMember->user_id = $groupChat->user_id;
        $newMember->group_id = $groupChat->id;
        $newMember->last_activity = time();
        $newMember->jtime = time();
        $newMember->saveThis();

        // Invite another operator
        $newMember = new erLhcoreClassModelGroupChatMember();
        $newMember->user_id = $operator->id;
        $newMember->group_id = $groupChat->id;
        $newMember->last_activity = time();
        $newMember->jtime = 0;
        $newMember->saveThis();
    }

    $db->commit();
    echo json_encode($groupChat->getState());

} catch (Exception $e) {
    http_response_code(400);
    echo erLhcoreClassRestAPIHandler::outputResponse(array(
        'error' => true,
        'r' => $e->getMessage()
    ));
}
exit;

?>