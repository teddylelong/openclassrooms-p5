<?php

namespace Entities;

class Role
{
    private int $pk_id;
    private string $name;
    private string $permissions;

    /**
     * @param int $pk_id
     */
    public function setPkId(int $pk_id): void
    {
        $this->pk_id = $pk_id;
    }

    /**
     * @return int
     */
    public function getPkId(): int
    {
        return $this->pk_id;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $permissions
     */
    public function setPermissions(string $permissions): void
    {
        $this->permissions = $permissions;
    }

    /**
     * @return string
     */
    public function getPermissions(): string
    {
        return $this->permissions;
    }
}