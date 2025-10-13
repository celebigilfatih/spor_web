<?php
/**
 * GroupModel
 * Youth and academy groups model
 */
class GroupModel extends Model
{
    protected $table = 'groups';

    /**
     * Get active groups
     */
    public function getActiveGroups()
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE status = 'active' 
                ORDER BY age_group ASC";
        return $this->db->query($sql);
    }

    /**
     * Get group by age category
     */
    public function getByAgeCategory($category)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE age_category = :category AND status = 'active'
                ORDER BY age_group ASC";
        return $this->db->query($sql, ['category' => $category]);
    }

    /**
     * Get academy information
     */
    public function getAcademyInfo()
    {
        return [
            'description' => 'Kulübümüz akademisi, genç yetenekleri keşfetmek ve geliştirmek amacıyla kurulmuştur.',
            'age_range' => '6-18 yaş arası',
            'training_days' => 'Pazartesi, Çarşamba, Cuma',
            'facilities' => ['Sentetik çim saha', 'Kapalı spor salonu', 'Fitness merkezi', 'Soyunma odaları']
        ];
    }

    /**
     * Get academy programs
     */
    public function getAcademyPrograms()
    {
        return [
            [
                'name' => 'Minikler (6-8 yaş)',
                'description' => 'Top ile tanışma ve temel motor beceriler',
                'training_frequency' => 'Haftada 2 gün'
            ],
            [
                'name' => 'Küçükler (9-11 yaş)',
                'description' => 'Temel futbol teknikleri ve oyun kuralları',
                'training_frequency' => 'Haftada 3 gün'
            ],
            [
                'name' => 'Yıldızlar (12-14 yaş)',
                'description' => 'Taktik bilgisi ve takım oyunu',
                'training_frequency' => 'Haftada 4 gün'
            ],
            [
                'name' => 'Gençler (15-18 yaş)',
                'description' => 'Profesyonel futbola hazırlık',
                'training_frequency' => 'Haftada 5 gün'
            ]
        ];
    }

    /**
     * Get enrollment information
     */
    public function getEnrollmentInfo()
    {
        return [
            'enrollment_period' => 'Her yıl Haziran-Ağustos',
            'requirements' => [
                'Sağlık raporu',
                'Veli onayı',
                'Fotoğraf (2 adet)',
                'Kimlik fotokopisi'
            ],
            'contact_email' => 'akademi@sporkulubu.com',
            'contact_phone' => '+90 (212) 555-0123'
        ];
    }

    /**
     * Get group coaches
     */
    public function getGroupCoaches($groupId)
    {
        $sql = "SELECT ts.* FROM technical_staff ts
                JOIN group_coaches gc ON ts.id = gc.coach_id
                WHERE gc.group_id = :group_id AND ts.status = 'active'";
        return $this->db->query($sql, ['group_id' => $groupId]);
    }

    /**
     * Get training schedule for a group
     */
    public function getTrainingSchedule($groupId)
    {
        $sql = "SELECT * FROM training_schedules 
                WHERE group_id = :group_id 
                ORDER BY day_of_week, start_time";
        return $this->db->query($sql, ['group_id' => $groupId]);
    }
}