<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%client_club}}`.
 */
class m240224_111332_create_client_club_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%client_club}}', [
            'client_id' => $this->integer(),
            'club_id' => $this->integer(),
            'PRIMARY KEY(client_id, club_id)',
            'FOREIGN KEY(client_id) REFERENCES client(id) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY(club_id) REFERENCES club(id) ON DELETE CASCADE ON UPDATE CASCADE',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%client_club}}');
    }
}
