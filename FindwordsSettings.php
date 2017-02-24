<?php

class FindWordspluginSettings {

    protected $option_name = 'FindWordsplugin-Settings';
    protected $data = array(
        'backgroundFindWordsplugin' => '#0000ff',
        'colorFindWordsplugin' => '#ff0000'
    );

    public
            function __construct() {
        add_action('init', array(
            $this,
            'init'
        ));
        add_action('admin_init', array(
            $this,
            'admin_init'
        ));
        add_action('admin_menu', array(
            $this,
            'add_page'
        ));
        register_activation_hook(FindWordspluginPLUGIN_FILE, array(
            $this,
            'activate'
        ));
        register_deactivation_hook(FindWordspluginPLUGIN_FILE, array(
            $this,
            'deactivate'
        ));
    }

    public
            function activate() {
				
        update_option($this->option_name, $this->data);
    }

    public
            function deactivate() {
        delete_option($this->option_name);
    }

    public
            function init() {
        $result = get_option('FindWordsplugin-Settings');

    }

    public
            function admin_init() {
        register_setting('FindWordsplugin_options', $this->option_name, array(
            $this,
            'validate'
        ));
    }

    public
            function add_page() {
        add_options_page('FindWordsplugin  Options', 'Findwords Options', 'manage_options', 'FindWordsplugin_options', array(
            $this,
            'options_FindWordsplugin_page'
        ));
    }

    public
            function options_FindWordsplugin_page() {
        $options = get_option($this->option_name);
        ?>
       
        <div class="wrap">
            <h2>FindWords plugin Options</h2>
            <form method="post" action="options.php">
        <?php settings_fields('FindWordsplugin_options'); ?>
                <table border="1" width="75%" class="form-table">
                    <TR>

                        <td width=25%><b>background Color</b><input type="color"  name="<?php echo $this->option_name ?>[backgroundFindWordsplugin]" value="<?php echo $options['backgroundFindWordsplugin']; ?>" /></td>
                        
                        <td width=25%><b>Text Color</b><input type="color" name="<?php echo $this->option_name ?>[colorFindWordsplugin]" value="<?php echo $options['colorFindWordsplugin']; ?>" /></td>

                      
                    </tr>
                   
                </table>
                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
                </p>
            </form>
        </div>
                                        <?php
                                    }

                                    public
                                            function validate($input) {
                                        var_dump($input);
                                        $valid = array();
                                        $valid['backgroundFindWordsplugin'] = $input['backgroundFindWordsplugin'];
                                        $valid['colorFindWordsplugin'] = $input['colorFindWordsplugin'];
                                        return $valid;
                                    }

                                }
                                