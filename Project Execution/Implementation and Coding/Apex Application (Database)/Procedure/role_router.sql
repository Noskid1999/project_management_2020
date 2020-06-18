CREATE OR REPLACE PROCEDURE "ROLE_ROUTER" 
AS 
    v_user_type VARCHAR2(6);
    l_to_page_num NUMBER;
    l_url VARCHAR2(4000);
BEGIN 
    SELECT User_type
    INTO v_user_type
    FROM users u
    WHERE upper(EMAIL) = V('APP_USER');    if upper(v_user_type) = 'ADMIN'        then
            l_to_page_num := 50;
        else
            l_to_page_num := 1;
        end if;
        l_url := 'f?p=' || v('APP_ID') || ':' || l_to_page_num || ':' || v('APP_SESSION');        APEX_UTIL.SET_SESSION_STATE('FSP_AFTER_LOGIN_URL', l_url); END;